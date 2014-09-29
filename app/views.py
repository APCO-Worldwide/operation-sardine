from flask import Response, send_file
from app import app
import serial

ser = serial.Serial('/dev/ttyACM0', 9600)

@app.route('/', methods=['GET'])
def index():
	return send_file("index.html")

@app.route('/on', methods=['POST'])
def turn_on():
	ser.write(b'1')
	return ""

@app.route('/off', methods=['POST'])
def turn_off():
	ser.write(b'0')
	return ""
