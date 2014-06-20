from flask import Response, send_file
from app import app
import serial

ser = serial.Serial('/dev/ttyACM0', 9600)

@app.route('/', methods=['GET'])
def index():
	return send_file("index.html")

@app.route('/green/on', methods=['POST'])
def turn_red_on():
	ser.write(b'1')
	return ""

@app.route('/red/on', methods=['POST'])
def turn_green_on():
	ser.write(b'2')
	return ""

@app.route('/all/off', methods=['POST'])
def turn_off():
	ser.write(b'3')
	return ""

