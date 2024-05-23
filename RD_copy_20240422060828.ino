// اضافه المكتبه
#include "LoRaWan_APP.h"
#include <Wire.h>
#include "HT_SSD1306Wire.h"
#include <WiFi.h>
#include <time.h>
#include <HTTPClient.h>


const char* ntpServer = "pool.ntp.org";
const long  gmtOffset_sec = 7200;
const int   daylightOffset_sec = 3600;

 char timeWeekDay[10];
 char timeHour[3];
 char timem[3];

#ifdef Wireless_Stick_V3
SSD1306Wire  display1(0x3c, 500000, SDA_OLED, SCL_OLED, GEOMETRY_64_32, RST_OLED); // addr , freq , i2c group , resolution , rst
#else
SSD1306Wire  display1(0x3c, 500000, SDA_OLED, SCL_OLED, GEOMETRY_128_64, RST_OLED); // addr , freq , i2c group , resolution , rst
#endif

//*************

//************* تفاصيل واعدادات استخدام لورا ***********
#define RF_FREQUENCY                                500000000 // Hz تردد النقل

#define TX_OUTPUT_POWER                             14        // dBm

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

static RadioEvents_t RadioEvents;

int16_t rssi, rxSize;

bool lora_idle = true;



//*********** نهايه اعدادات لورا **********

// تعريف متغيرات
String message ;   // متغير لتخزين رساله لورا المستقبله
String name ;      // متغير لتخزين قيمه الحراره
String Id;  // متغير لتخزين قيمه  الضغط



char ssid[] = "mynet";   // your network SSID (name)
char pass[] = "11112223";   // your network password
WiFiClient  client;



// ************** كود يتم تشغيله مره واحده عن تشغيل المشروع ***************
void setup() {
  Serial.begin(9600);      // بدا التواصل مه الكمبيوتر
  Mcu.begin();
  VextON();     // تفعيل مصدر الطاقه للشاشه الصغيره لانه مغلق في البدايه
  delay(100);      // انتظار
  // تشغيل الشاشه
  display1.init();
  display1.display();

  display1.setFont(ArialMT_Plain_16);    // تحديد الخط والمقاس
  display1.setTextAlignment(TEXT_ALIGN_LEFT);   // تحديد مكان الخط في الشاشه
     
  rssi = 0;                                  // متغير لتخزين قوه الاشاره القادمه

  //******* اكواد خاصه باستقبال رساله لورا ************
  RadioEvents.RxDone = OnRxDone;
  Radio.Init( &RadioEvents );
  Radio.SetChannel( RF_FREQUENCY );
  Radio.SetRxConfig( MODEM_LORA, LORA_BANDWIDTH, LORA_SPREADING_FACTOR,
                     LORA_CODINGRATE, 0, LORA_PREAMBLE_LENGTH,
                     LORA_SYMBOL_TIMEOUT, LORA_FIX_LENGTH_PAYLOAD_ON,
                     0, true, 0, 0, LORA_IQ_INVERSION_ON, true );
  //****************************************************

  Serial.println();
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);

    WiFi.begin(ssid, pass);

    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());



    configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
    

  display1.clear();                                             // حذف القيم القديمه
  display1.drawString(0, 0, "Connected to " );            // تحديد مكان كتابه النص وماذا نكتب
  display1.drawString(0, 32, ssid );  
  display1.display();    

}


//**************************** هذا الكود يتكرر مشكل لانهائي******************
void loop()
{
  if (lora_idle)       //**** التاكد من انتهاء القراءه السابقه ثم يتم قراءه رياله لورا من جديد
  {
    lora_idle = false;
    Serial.println("into RX mode");      // طباعه جمله بدا استماع الرسائل
    Radio.Rx(0);
  }
  Radio.IrqProcess( );  
  
              // داله خاصه ب لورا للتاكد من استقبال الرساله كامله وغيرها من التفاصيل

}

// داله خاصه ب لورا يتم تشغيلها بعد كل قراءه للرساله***************

void OnRxDone( uint8_t *payload, uint16_t size, int16_t rssi, int8_t snr )
{
  rssi = rssi;          // قوه اشاره الرساله
  rxSize = size;        // حجم الرساله
  memcpy(rxpacket, payload, size );    // تخزين محتوى الرساله في متغير  repacket
  rxpacket[size] = '\0';
  Radio.Sleep( );          //الدخول وضع النوم حتى لا نستقبل قيم جديده حاليا
  Serial.printf("\r\nreceived packet \"%s\" with rssi %d , length %d\r\n", rxpacket, rssi, rxSize);  
  Serial.println(""); // طباعه على الكمبيوتر تفاصيل الرساله المتقبله
  lora_idle = true;
  message = (String(rxpacket));   // تخزين محتوى الرساله بشكل " نص " الى متغير اسمه  message

  // ********************** البدا بتحليل محتوى الرساله واخذ المعلومات**************

  int index = message.indexOf("N");
  if (index >= 0) 
  {
    name = message.substring(0, index);
    Serial.print("Student Name:" + name );   // طباعه الاسم على الشاشه

    Id = message.substring(index +1  , message.indexOf("X"));
    Id = Id.toInt();                     // تحويل القيمه الى رقم
    Serial.println("| Id:" + String(Id)); // طباعه القيمه على الشاشه

   

    HTTPClient http;
    http.begin("https://ragorr.dreamhosters.com/public/api/attendance?"); //Specify the URL
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    struct tm timeinfo;
    if(!getLocalTime(&timeinfo)){
      Serial.println("Failed to obtain time");
       
     } 

     else{


    strftime(timeWeekDay,10, "%A", &timeinfo);
    strftime(timeHour,3, "%I", &timeinfo  );
    strftime( timem,3, "%M", &timeinfo);

    
   }

     
  
    String httpRequestData = "StudentID=" + Id + "&TimeIn=" + timeHour + ":" + timem + "&Day=" + timeWeekDay  ;
                       
    Serial.println(httpRequestData);

    int httpCode = http.POST(httpRequestData); //Make the request
            
    if (httpCode > 0) { //Check for the returning code
  
        String payload = http.getString();
        Serial.println(httpCode);
        Serial.println(payload);}
  
    else {
      Serial.println("Error on HTTP request");
      while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
    }
  
    http.end(); //Free the resources
    }


  


}


//****** داله خاصه بتشغيل الطاقه للشاشه الصغيره***********
void VextON(void)
{
  pinMode(Vext, OUTPUT);
  digitalWrite(Vext, LOW);
}

