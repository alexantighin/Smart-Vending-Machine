
import MySQLdb
import serial
import time
from datetime import datetime

time.sleep(3)

now = datetime.now()
print (now.strftime("%Y-%m-%d %H:%M:%S"))

port ="/dev/ttyUSB0"
Arduino_UNO = serial.Serial(port,baudrate=9600)

db = MySQLdb.connect(host="localhost",
		     user="admin",
		     passwd="antighin",
		     db="smart_vending_machine")
sql = db.cursor()

sql.execute("SELECT RGB FROM produse")

i=0
RGB_produs = [0, 0, 0]
for row in sql.fetchall():
    RGB_produs[i] = row[0]
    i+=1 

db.close()

mesaj_pentru_arduino = "M"
for j in RGB_produs:
	mesaj_pentru_arduino += str(j)

Arduino_UNO.write(mesaj_pentru_arduino)

print "-> Am trimis mesajul:  ",
print mesaj_pentru_arduino,
print "catre arduino"

print "-----------------------------------------------------------------"
