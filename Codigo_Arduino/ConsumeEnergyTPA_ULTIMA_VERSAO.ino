#include <EmonLib.h>

#include <Ethernet.h>
#include <MySQL_Connection.h>
#include <MySQL_Cursor.h>
#include <SPI.h>

#include <Thermistor.h>

#define LM35 A0

int leitura;
float leituraconvertida;
char sentenca[128];
char valorIrms[10];

int pino = A0;
EnergyMonitor emon1;


// Variável do sensor de temperaturae LED:
Thermistor temp(15);
int ledTemp = A10;
int estadoButtonTemp = 0;
int pushbutton = A9;


// Variáveis da Corrente
bool estadoled = 0;
int pushled = A8;
int led = A12;

// Controle do Ethernet Shield
byte mac_addr[] = { 0xA8, 0xA1, 0x59, 0x6F, 0x7C, 0x3D };  
IPAddress server_addr(192,168,100,111);  
char user[] = "arduino";              
char password[] = "arduino123";

// Comandos a serem executados no banco
char INSERIR_ENERGIA[] = "INSERT INTO consume_energy (user_id, consume, credits) values (23, %s, 0)";
char SELECT_CREDITS[] = "SELECT credits FROM consume_energy WHERE id = 403";
char INSERIR_TEMPERATURA[] = "UPDATE temperatura SET temperatura = (%d) WHERE id = 1";
char BANCODEDADOS[] = "USE controle_energia";

EthernetClient client;
MySQL_Connection conn((Client *)&client);
MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);




void setup() 
{
  // LED e Botão da Temperatura
  pinMode(ledTemp, OUTPUT);
  pinMode(pushbutton, INPUT);

  // LED e Botão da Corrente

  pinMode(pino, OUTPUT);
  pinMode(led, OUTPUT);
  pinMode(pushled, INPUT);


   Serial.begin(9600);

   emon1.current(pino, 100);
   
   while (!Serial); 
   Ethernet.begin(mac_addr);
   Serial.println("Conectando...");
   if (conn.connect(server_addr, 3306, user, password)) 
   {
      delay(1000);
      cur_mem->execute(BANCODEDADOS);
      //delete cur_mem;
   }
   else
   {
      Serial.println("A conexão falhou");
      //conn.close();
   }
}




void loop() 
{
  estadoButtonTemp = digitalRead(pushbutton);
  estadoled = digitalRead(pushled);

  Serial.println("");


  row_values *row = NULL;
  long credits = 0;
  // Calcular e exibir a corrente
   double Irms = emon1.calcIrms(1480);
   
   delay(1000);

   cur_mem->execute(SELECT_CREDITS);
   column_names *columns = cur_mem->get_columns();

   do {
    row = cur_mem->get_next_row();
    if (row != NULL) {
      credits = atol(row->values[0]);
    }
  } while (row != NULL);



  // Saída digital 1: IF dos créditos
  if (credits > 0) {
    digitalWrite(pino, LOW);
  } else {
    digitalWrite(pino, HIGH);
  }

  Serial.print("Creditos: ");  
  Serial.println(credits);
  


  leitura = analogRead(LM35);
  leituraconvertida = Irms;

  double khm = (Irms * 10000)/1000;



  if (estadoled == HIGH) {
      digitalWrite(led, LOW);
      khm = 0;

  } else {
      digitalWrite(led, HIGH);

  }



  dtostrf(khm, 4, 4, valorIrms);
  sprintf(sentenca, INSERIR_ENERGIA, valorIrms);
  MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
  cur_mem->execute(sentenca);

    


  // Calcular e exibir temperatura:
  // Variável da temperatura que recebe o valor da temperatura atual calculado pela biblioteca
  int temperature;
    
  if (estadoButtonTemp == HIGH) {
    temperature = 200;
  } else {
    temperature = temp.getTemp();
  }
    
  if (temperature < 100) {
      digitalWrite(ledTemp, LOW);

  } else {
      digitalWrite(ledTemp, HIGH);
      temperature = 0;
  }


    char valorTemp = temperature;
    sprintf(sentenca, INSERIR_TEMPERATURA, valorTemp);
    
    cur_mem->execute(sentenca);
    delete cur_mem;

    Serial.print("Temperatura: ");
    Serial.print(temperature);
    Serial.println("*C");
   
    Serial.print("Corrente: ");
    Serial.println(khm);

    Serial.println("__________________________");

    delay(5000);
    
}