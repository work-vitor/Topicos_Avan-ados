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

// Variável do sensor de temperatura:
Thermistor temp(15);

// Controle do Ethernet Shield
byte mac_addr[] = { 0xA8, 0xA1, 0x59, 0x6F, 0x7C, 0x3D };  
IPAddress server_addr(85,10,205,173);  
char user[] = "arduino";              
char password[] = "arduino123";

// Comandos a serem executados no banco
char INSERIR_ENERGIA[] = "INSERT INTO consume_energy (user_id, consume, credits) values (1, %s, 0)";
char SELECT_CREDIT[] = "SELECT credits FROM consume_energy WHERE user_id = 1";
char INSERIR_TEMPERATURA[] = "UPDATE temperatura SET temperatura = (%d) WHERE user_id = 1";
char BANCODEDADOS[] = "USE controle_energia";

EthernetClient client;
MySQL_Connection conn((Client *)&client);

void setup() 
{ 
   Serial.begin(9600);

   emon1.current(pino, 100);
   
   while (!Serial); 
   Ethernet.begin(mac_addr);
   Serial.println("Conectando...");
   if (conn.connect(server_addr, 3306, user, password)) 
   {
      delay(1000);
      
      MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
      cur_mem->execute(BANCODEDADOS);
      delete cur_mem;
   }
   else
   {
      Serial.println("A conexão falhou");
      conn.close();
   }
}

void loop() 
{
  // Calcular e exibir a corrente
   double Irms = emon1.calcIrms(1480);

   Serial.println("Executando sentença");
   leitura = analogRead(LM35);
   leituraconvertida = Irms;

   double khm = (Irms * 10000)/1000;
   dtostrf(khm, 4, 4, valorIrms);
   sprintf(sentenca, INSERIR_ENERGIA, valorIrms);
   MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
		cur_mem->execute(sentenca);
    delete cur_mem;
    
  // Calcular e exibir temperatura:
    int temperature = temp.getTemp(); // Variável da temperatura que recebe o valor da temperatura atual calculado pela biblioteca
    Serial.print("Temperatura: ");
    Serial.print(temperature);
    Serial.println("*C");

    char valorTemp = temperature;
    sprintf(sentenca, INSERIR_TEMPERATURA, valorTemp);
	  
    cur_mem->execute(sentenca);
    delete cur_mem;
   
    Serial.print("Corrente: ");
    Serial.println(khm);

    delay(5000);
    
}