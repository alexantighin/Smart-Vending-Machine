#!/user/bin/env python
import serial
port= "/dev/ttyUSB0"
Arduino_UNO = serial.Serial(port,baudrate=9600)
Arduino_UNO.write('s')
