#!/usr/bin/python
import subprocess
import MySQLdb
import time
from datetime import datetime

now = datetime.now()
print (now.strftime("%Y-%m-%d %H:%M:%S"))
db = MySQLdb.connect(host="localhost",
		     user="admin",
		     passwd="antighin",
		     db="smart_vending_machine")
sql = db.cursor()
sql.execute("SELECT mac_utilizator FROM utilizatori")
i=0
MAC_utilizatori = [ ]
for row in sql.fetchall():
	MAC_utilizatori.append(row[0])
print MAC_utilizatori

p = subprocess.Popen(" sudo arp-scan -l", stdout=subprocess.PIPE, shell=True)
(output, err) = p.communicate()
status = p.wait()
print output

for x in MAC_utilizatori:
	if x in output:
		comanda = "SELECT id_utilizator FROM utilizatori WHERE mac_utilizator = %s"
		adr = (x, )
		sql.execute(comanda, adr)
		id_utilizator = sql.fetchall()[0][0]

		comanda = "SELECT IF((ultima_conectare + INTERVAL 1 SECOND)  < now(), 1, 0) FROM detalii_utilizatori WHERE id_utilizator = %s;"
                adr = (id_utilizator, )
                sql.execute(comanda, adr)
                interval_validare = sql.fetchall()[0][0]
		if(interval_validare):
			comanda = "SELECT id_produs FROM detalii_utilizatori WHERE id_utilizator = %s"
                	adr = (id_utilizator, )
                	sql.execute(comanda, adr)
                	id_produs =  sql.fetchall()[0][0]

			comanda = "SELECT disponibilitate FROM produse WHERE id_produs = %s"
                	adr = (id_produs, )
                	sql.execute(comanda, adr)
                	disponibilitate = sql.fetchall()[0][0]

                	if(int(disponibilitate) >= 2):
                        	comanda="UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs= %s "
                        	adr = (id_produs, )
                        	sql.execute(comanda, adr)
                        	db.commit()
                		if(id_produs == 1):
                        		subprocess.call(['python', '/var/www/arduino/./q.py'])
                        		time.sleep(3)
                		if(id_produs == 2):
                        		subprocess.call(['python', '/var/www/arduino/./a.py'])
                        		time.sleep(3)
                		if(id_produs == 3):
                        		subprocess.call(['python', '/var/www/arduino/./z.py'])
                        		time.sleep(3)
				comanda="UPDATE detalii_utilizatori SET ultima_conectare = now() WHERE id_utilizator= %s "
                                adr = (id_utilizator, )
                                sql.execute(comanda, adr)
                                db.commit()
				print "-> Am activat procesul de automatizare pentru userul: ",
				print x,
				print "si am livrat produsul",
				print id_produs

print "-----------------------------------------------------------------"


