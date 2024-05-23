#include "LoRaWan_APP.h"
#include <Wire.h>
#include "HT_SSD1306Wire.h"
#include <WiFi.h>
#include <time.h>
#include <HTTPClient.h>
HardwareSerial mySerial(2);  // تفعيل منفذ السيريال الثاني اللي في ESP  لان الاول مرتبط مع الكمبيوتر ويغرض النتائج


int v1 =2;
int v2 =45;
String id = "22";

String message ;           // الرساله التي سيتم ارسالها الى المتحكم الاخر وتحتوي على قيم المتغيرات

bool lora_idle = true ;        // متغير خاص ب لورا


char ssid[] = "mynet";   // your network SSID (name)
char pass[] = "11112223";   // your network password

const unsigned long interval =5000;

unsigned long previousmillis=0;
unsigned long currentmillis;


#ifdef Wireless_Stick_V3
SSD1306Wire  display1(0x3c, 500000, SDA_OLED, SCL_OLED, GEOMETRY_64_32, RST_OLED); // addr , freq , i2c group , resolution , rst
#else
SSD1306Wire  display1(0x3c, 500000, SDA_OLED, SCL_OLED, GEOMETRY_128_64, RST_OLED); // addr , freq , i2c group , resolution , rst
#endif

//*********** تحديد معايير لورا مثل التردد وغيره ************

#define RF_FREQUENCY                                500000000 // Hz

#define TX_OUTPUT_POWER                             5        // dBm

#define LORA_BANDWIDTH                              0         // [0: 125 kHz,
//  1: 250 kHz,
//  2: 500 kHz,
//  3: Reserved]
#define LORA_SPREADING_FACTOR                       7         // [SF7..SF12]
#define LORA_CODINGRATE                             1         // [1: 4/5,
//  2: 4/6,
//  3: 4/7,
//  4: 4/8]
#define LORA_PREAMBLE_LENGTH                        8         // Same for Tx and Rx
#define LORA_SYMBOL_TIMEOUT                         0         // Symbols
#define LORA_FIX_LENGTH_PAYLOAD_ON                  false
#define LORA_IQ_INVERSION_ON                        false


#define RX_TIMEOUT_VALUE                            1000
#define BUFFER_SIZE                                 30 // Define the payload size here




char txpacket[BUFFER_SIZE];
char rxpacket[BUFFER_SIZE];

int t=1;

static RadioEvents_t RadioEvents;
void OnTxDone( void );
void OnTxTimeout( void );
//****************************** انتهت تفاصيل لورا **************************

//************************** هذا الكود يعمل مره وحده عند تشغيل المشروع ***************************
void setup() {

  pinMode(v1,OUTPUT);
  pinMode(v2,OUTPUT);

  Serial.begin(9600); // تفعيل التواصل مع الشاشه لعرض القيم
 
  Serial.println("Initializing...");    // طباعه كلمه " جاري التشغيل"
  // تشغيل الشاشه
  display1.init();
  display1.display();
  display1.setFont(ArialMT_Plain_24);    // تحديد الخط والمقاس
  display1.setTextAlignment(TEXT_ALIGN_CENTER_BOTH );   // تحديد مكان الخط في الشاشه

  // اكواد مساعده في ارسال البيانات باستخدام لورا
  Mcu.begin();
  RadioEvents.TxDone = OnTxDone;
  RadioEvents.TxTimeout = OnTxTimeout;

  Radio.Init( &RadioEvents );
  Radio.SetChannel( RF_FREQUENCY );
  Radio.SetTxConfig( MODEM_LORA, TX_OUTPUT_POWER, 0, LORA_BANDWIDTH,
                     LORA_SPREADING_FACTOR, LORA_CODINGRATE,
                     LORA_PREAMBLE_LENGTH, LORA_FIX_LENGTH_PAYLOAD_ON,
                     true, 0, 0, LORA_IQ_INVERSION_ON, 3000 );

                     Serial.println();
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);

    WiFi.begin(ssid, pass);

    while (WiFi.status() != WL_CONNECTED) {
        delay(100);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
}


//***************************************** هذا الكود يعمل بشكل متكرر الى مالانهايه *********************************
void loop()
{

  currentmillis = millis();

          message = "ٌRaghad";
          message +=  "N"; 
          message += "22";   
          message += "X"; 
    
          

                              // نضيف قيمه الحساس الى المتغير

          sprintf(txpacket, "%s", message.c_str()); // نجهز رساله لورا التي سنرسلها الى المتحكم الاخر (سيتم ارسال المتغير حقنا)  message

          Serial.printf("\r\nsending packet \"%s\" , length %d\r\n", txpacket, strlen(txpacket));       // طباعه على الكمبيوتر تفاصيل الرساله قبل ارسالها للتاكد منها

          Radio.Send( (uint8_t *)txpacket, strlen(txpacket) );                   // ارسال الرساله للمتحكم الاخر
          delay(500);                                    // انتظار نص ثانيه
          

        
        

        // أكواد الكتابه على الشاشه الصغيره**************
        display1.clear();                                             // حذف القيم القديمه
        display1.drawString(64, 32, "Raghad");            // تحديد مكان كتابه النص وماذا نكتب
 
        display1.display();      

        if(currentmillis - previousmillis >= interval){

        


        HTTPClient http;
        http.begin("https://ragorr.dreamhosters.com/public/api/vibration"); //Specify the URL
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        String httpRequestData = "id=" + id  ;
                       
        Serial.println(httpRequestData);

        int httpCode = http.POST(httpRequestData); //Make the request

        if (httpCode > 0) { //Check for the returning code
  
        String payload = http.getString();
        Serial.println(httpCode);
        Serial.println(payload);

        if(payload == "0") { Serial.println("No vibration"); digitalWrite(v1,LOW); digitalWrite(v2,LOW); }
        else { Serial.println("vibration"); digitalWrite(v1,HIGH); digitalWrite(v2,HIGH); }
        
        
        
        
        
        
        }
  
    else {
      Serial.println("Error on HTTP request");
     
    }
  
    http.end(); //Free the resources
    
   previousmillis = currentmillis ;
        }
  

  Radio.IrqProcess( );       // داله ثابته تقوم بالتاكد من بدا ارسال الرساله ونسبه اكتمالها وغيرها من التفاصيل
}

// داله خاصه بمكتبه لورا
void OnTxDone( void )
{
  Serial.println("TX done......");
  lora_idle = true;
}
// داله خاصه بمكتبه لورا
void OnTxTimeout( void )
{
  Radio.Sleep( );
  Serial.println("TX Timeout......");
  lora_idle = true;
}
