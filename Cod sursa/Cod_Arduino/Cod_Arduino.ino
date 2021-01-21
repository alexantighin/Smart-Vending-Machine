const int motor1 = 9;
const int motor2 = 10;
const int motor3 = 11;

#define motor_1_led_red_pin     3
#define motor_2_led_blue_pin    6
#define motor_3_led_green_pin   5

char inputBuffer[16];

bool primire_mesaj_baza_de_date;

bool led_motor_1;
bool led_motor_2;
bool led_motor_3;

void(* resetSoftware)(void) = 0;

void setup() {
  pinMode(motor_1_led_red_pin,      OUTPUT);
  pinMode(motor_2_led_blue_pin,     OUTPUT);
  pinMode(motor_3_led_green_pin,    OUTPUT);

  primire_mesaj_baza_de_date = false;
  led_motor_1 = false;
  led_motor_2 = false;
  led_motor_3 = false;
  rgb();

  Serial.begin(9600);
  Serial.println("\n*****************************************");
  Serial.println("\tSmart Vending Machine ");
  Serial.println("    © Antighin Alexandru - Andrei");
  Serial.println("*****************************************\n");
}

void loop()
{
  if(Serial.available() > 0)  // Verificare daca comunicatia Seriala este disponibila
  {
    Serial.readBytesUntil('\n', inputBuffer, 16);   // Memoreaza in inputBuffer sirul de caractere primit de la Raspberry Pi

    /* Reset Arduino UNO */
    if( strcmp( "arduino_reset" , inputBuffer ) == 0 )
    {
      resetSoftware();     
    }

    if(primire_mesaj_baza_de_date == false)
    {
      if( inputBuffer[0] == 'M' )
      {
        primire_mesaj_baza_de_date = true;
        
        if(inputBuffer[1] == '0')
        {
          led_motor_1 = false;
        }
        else if(inputBuffer[1] == '1')
        {
          led_motor_1 = true;
        }

        if(inputBuffer[2] == '0')
        {
          led_motor_2 = false;
        }
        else if(inputBuffer[2] == '1')
        {
          led_motor_2 = true;
        }

        if(inputBuffer[3] == '0')
        {
          led_motor_3 = false;
        }
        else if(inputBuffer[3] == '1')
        {
          led_motor_3 = true;
        }
                
        rgb();
      }
    }
    else if(primire_mesaj_baza_de_date == true)
    {
        /* Control Servomotor 1 */      
        if( strcmp( "q" , inputBuffer ) == 0 )
        {
          led_motor1_on();
          led_motor2_off();
          led_motor3_off();
          delay(500);
          for(int i=0; i< 122; i++)
          {
              digitalWrite(motor1,HIGH);  // semnal de High
              delayMicroseconds(1884);    // durata pulsatie
              digitalWrite(motor1,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 1 - STANGA FULL - <<< \t\t\t\t");  
          delay(500);
          rgb();      
        }
        if( strcmp( "w" , inputBuffer ) == 0 )
        {
          for(int i=0; i< 5; i++)
          {
              digitalWrite(motor1,HIGH);  // semnal de High
              delayMicroseconds(1729);    // durata pulsatie
              digitalWrite(motor1,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 1 - STANGA - <<< \t\t\t\t");    
        }
        if( strcmp( "e" , inputBuffer ) == 0 )
        {
          for(int i=0; i< 5; i++)
          {
              digitalWrite(motor1,HIGH);  // semnal de High
              delayMicroseconds(1265);    // durata pulsatie
              digitalWrite(motor1,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 1 - DREAPTA - <<< \t\t\t\t");   
        }
        if( strcmp( "r" , inputBuffer ) == 0 )
        {
          led_motor1_on();
          led_motor2_off();
          led_motor3_off();
          delay(500);
          for(int i=0; i< 131; i++)
          {
              digitalWrite(motor1,HIGH);  // semnal de High
              delayMicroseconds(1111);    // durata pulsatie
              digitalWrite(motor1,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 1 - DREAPTA FULL - <<< \t\t\t\t");  
          delay(500);
          rgb();       
        }        

        /* Control Servomotor 2 */
        if( strcmp( "a" , inputBuffer ) == 0 )
        {
          led_motor1_off();
          led_motor2_on();
          led_motor3_off();
          delay(500);
          for(int i=0; i< 102; i++)
          {
              digitalWrite(motor2,HIGH);  // semnal de High
              delayMicroseconds(894);    // durata pulsatie
              digitalWrite(motor2,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 2 - STANGA FULL - <<< \t\t\t\t");  
          delay(500);
          rgb();       
        }
        if( strcmp( "s" , inputBuffer ) == 0 )
        {
          for(int i=0; i< 5; i++)
          {
              digitalWrite(motor2,HIGH);  // semnal de High
              delayMicroseconds(864);    // durata pulsatie
              digitalWrite(motor2,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 2 - STANGA - <<< \t\t\t\t");    
        }
        if( strcmp( "d" , inputBuffer ) == 0 )
        {
          for(int i=0; i< 5; i++)
          {
              digitalWrite(motor2,HIGH);  // semnal de High
              delayMicroseconds(812);    // durata pulsatie
              digitalWrite(motor2,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 2 - DREAPTA - <<< \t\t\t\t");    
        }
        if( strcmp( "f" , inputBuffer ) == 0 )
        {
          led_motor1_off();
          led_motor2_on();
          led_motor3_off();
          delay(500);
          for(int i=0; i< 122; i++)
          {
              digitalWrite(motor2,HIGH);  // semnal de High
              delayMicroseconds(791);    // durata pulsatie
              digitalWrite(motor2,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 2 - DREAPTA FULL - <<< \t\t\t\t");  
          delay(500);
          rgb();       
        }

        /* Control Servomotor 3 */
        if( strcmp( "z" , inputBuffer ) == 0 )
        {
          led_motor1_off();
          led_motor2_off();
          led_motor3_on();
          delay(500);
          for(int i=0; i< 128; i++)
          {
              digitalWrite(motor3,HIGH);  // semnal de High
              delayMicroseconds(1884);    // durata pulsatie
              digitalWrite(motor3,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 3 - STANGA FULL - <<< \t\t\t\t");  
          delay(500);
          rgb();       
        }
        if( strcmp( "x" , inputBuffer ) == 0 )
        {
          for(int i=0; i< 5; i++)
          {
              digitalWrite(motor3,HIGH);  // semnal de High
              delayMicroseconds(1729);    // durata pulsatie
              digitalWrite(motor3,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 3 - STANGA - <<< \t\t\t\t");     
        }
        if( strcmp( "c" , inputBuffer ) == 0 )
        {
          for(int i=0; i< 5; i++)
          {
              digitalWrite(motor3,HIGH);  // semnal de High
              delayMicroseconds(1265);    // durata pulsatie
              digitalWrite(motor3,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 1 - DREAPTA - <<< \t\t\t\t");    
        }
        if( strcmp( "v" , inputBuffer ) == 0 )
        {
          led_motor1_off();
          led_motor2_off();
          led_motor3_on();
          delay(500);
          for(int i=0; i< 137; i++)
          {
              digitalWrite(motor3,HIGH);  // semnal de High
              delayMicroseconds(1111);    // durata pulsatie
              digitalWrite(motor3,LOW);   // semnal de Low
              delay(20);
          }
          Serial.print("\nMotor 1 - DREAPTA FULL - <<< \t\t\t\t");  
          delay(500);
          rgb();   
        }

        /*  Control LED-uri ON / OFF */

        if( strcmp( "led_motor1_on" , inputBuffer ) == 0 )
        {
          led_motor_1 = true;
          led_motor1_on();
        }
        if( strcmp( "led_motor1_off" , inputBuffer ) == 0 )
        {
          led_motor_1 = false;
          led_motor1_off();
        }

        if( strcmp( "led_motor2_on" , inputBuffer ) == 0 )
        {
          led_motor_2 = true;
          led_motor2_on();
        }
        if( strcmp( "led_motor2_off" , inputBuffer ) == 0 )
        {
          led_motor_2 = false;
          led_motor2_off();
        }

        if( strcmp( "led_motor3_on" , inputBuffer ) == 0 )
        {
          led_motor_3 = true;
          led_motor3_on();
        }
        if( strcmp( "led_motor3_off" , inputBuffer ) == 0 )
        {
          led_motor_3 = false;
          led_motor3_off();
        }      
   } 
  }
  memset(inputBuffer, 0, sizeof(inputBuffer));      // trasnsforma elementele vectorului in 0
}

void rgb()
{
  if(led_motor_1 == true)
  {
    led_motor1_on();
  }
  else
  {
    led_motor1_off();
  }

  if(led_motor_2 == true)
  {
    led_motor2_on();
  }
  else
  {
    led_motor2_off();
  }

  if(led_motor_3 == true)
  {
    led_motor3_on();
  }
  else
  {
    led_motor3_off();
  }
}

void led_motor1_on()
{
  analogWrite(motor_1_led_red_pin,    255);
}

void led_motor2_on()
{
  analogWrite(motor_2_led_blue_pin,   255);
}

void led_motor3_on()
{
  analogWrite(motor_3_led_green_pin,  255);
}

void led_motor1_off()
{
  analogWrite(motor_1_led_red_pin,    0);
}

void led_motor2_off()
{
  analogWrite(motor_2_led_blue_pin,   0);
}

void led_motor3_off()
{
  analogWrite(motor_3_led_green_pin,  0);
}
