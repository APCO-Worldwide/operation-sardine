void setup() {
	Serial.begin(9600);
}

void loop() {
	if (Serial.available() > 0) {
		char inByte = Serial.read();

		if(inByte == '1') {
			digitalWrite(13,HIGH);
		}

		else if(inByte == '0') {
			digitalWrite(13,LOW);
		}
	}
}