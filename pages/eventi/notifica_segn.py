#! /usr/bin/env python
# -*- coding: utf-8 -*-
#   Gter Copyleft 2018
#   Roberto Marzocchi

import os
#import urllib2 #problema con python3
import urllib.request
import xml.etree.ElementTree as et

import psycopg2
from conn import *

import time
import datetime
import telepot
import emoji
from emoji import emojize


import config
# Il token è contenuto nel file config.py e non è aggiornato su GitHub per evitare utilizzi impropri
TOKEN=config.TOKEN

bot = telepot.Bot(TOKEN)
#per ora solo un test su Roberto
#chat_id= config.chat_id


sito_allerta="http://www.allertaliguria.gov.it"
abs_path_bollettini="/opt/rh/httpd24/root/var/www/html"


 


def scarica_bollettino(tipo,nome,ora):
    if os.path.isfile("{}/bollettini/{}/{}".format(abs_path_bollettini,tipo,nome))==False:
        if ora!='NULL':
            data_read=datetime.datetime.strptime(ora,"%Y%m%d%H%M")
            print(data_read)
        f = urllib.request.urlopen("{}/docs/{}".format(sito_allerta,nome))
        data = f.read()
        with open("{}/bollettini/{}/{}".format(abs_path_bollettini,tipo,nome), "wb") as code:
            code.write(data)
        conn = psycopg2.connect(host=ip, dbname=db, user=user, password=pwd, port=port)
        curr = conn.cursor()
        conn.autocommit = True
        if ora!='NULL':
            query = "INSERT INTO eventi.t_bollettini(tipo, nomefile, data_ora_emissione)VALUES ('{}', '{}', '{}')".format(tipo,nome,data_read);
        else:
            query = "INSERT INTO eventi.t_bollettini(tipo, nomefile)VALUES ('{}', '{}')".format(tipo,nome);
        #print(query)
        curr.execute(query)
        print("Download completed...")
        #SEND BOT
        if tipo == 'PC':
            messaggio = "{}/docs/{}".format(sito_allerta,nome)
            # ciclo for sulle chat_id
            query_chat_id= "SELECT telegram_id from users.v_utenti_sistema where telegram_id !='' and telegram_attivo='t' and (id_profilo='1' or id_profilo ='2' or id_profilo ='3');"
            curr.execute(query_chat_id)
            lista_chat_id = curr.fetchall() 
            #print("Print each row and it's columns values")
            for row in lista_chat_id:
                chat_id=row[0]
                bot.sendMessage(chat_id, "Nuovo bollettino Protezione civile!")
                bot.sendMessage(chat_id, messaggio)
                time.sleep(1)
    else:
        print("File already download")
        #if tipo == 'PC':
        #    messaggio = "{}/docs/{}".format(sito_allerta,nome)
        #    bot.sendMessage(chat_id, "Bollettino Protezione civile già scaricato!")
        #    bot.sendMessage(chat_id, messaggio)
        



def main():
    conn = psycopg2.connect(host=ip, dbname=db, user=user, password=pwd, port=port)
    curr = conn.cursor()
    conn.autocommit = True
    current_time = datetime.datetime.now()
    print(current_time)
    query= "SELECT count(id) " \
           "FROM segnalazioni.v_segnalazioni " \
           "WHERE in_lavorazione is null AND (fine_sospensione <'{}' OR fine_sospensione is null)" .format(current_time)
    print(query)
    curr.execute(query)
    segn = curr.fetchall()
    # print("Print each row and it's columns values")
    for row in segn:
        if row[0] > 0:
            count_s=row[0]
            print('Ci sono {} segnalazioni in sospeso. Devo mandare notifica'.format(count_s))
            messaggio = emoji.emojize(":warning: Ci sono {} segnalazioni in sospeso".format(count_s),use_aliases=True)
            messaggio2="{} (Questo è un messaggio automatico che ricevi ogni 6 ore in quanto operatore di Protezione Civile)".format(messaggio)
            # ciclo for sulle chat_id
            query_chat_id = "SELECT telegram_id from users.v_utenti_sistema where telegram_id !='' and telegram_attivo='t' and (id_profilo='1' or id_profilo ='2' or id_profilo ='3');"
            curr.execute(query_chat_id)
            lista_chat_id = curr.fetchall()
            # print("Print each row and it's columns values")
            for row2 in lista_chat_id:
                chat_id = row2[0]
                print(datetime.datetime.now())
                print(messaggio2)
                print(chat_id)
                if chat_id=='708309739':
                    #bot.sendMessage(chat_id,emoji.emojize(":warning: Ci sono {} segnalazioni in sospeso. (Questo è un messaggio automatico che ricevi ogni ora in quanto operatore di Protezione Civile)'".format(count_s),use_aliases=True))
                    bot.sendMessage(chat_id, messaggio2)
                    print('Messaggio inviato')
                    print(datetime.datetime.now())
                time.sleep(1)

        
        
if __name__ == "__main__":
    main()
