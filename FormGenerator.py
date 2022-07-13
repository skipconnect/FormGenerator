import streamlit as st
import pandas as pd
import numpy as np

## Header
st.markdown("<h1 style='text-align: center; color: grey;'>DanskHR Tildmeldingsformular</h1>", unsafe_allow_html=True)

## Eventnavn
st.header("Angiv navnet på eventet")
Name = st.text_input('Skriv navnet på eventet nedenfor', "Navn på event", key="EventName")


## Eventbeskrivelse
st.header("Angiv beskrivelse af eventet")
Description = st.text_area('Skriv en beskrivelse af eventet nedenfor', "Beskrivelse..",height=200, key="EventDescription")


## Praktiske oplysninger
st.header("")
st.header("")
st.header("Tilføj Praktiske oplysninger")
col1, col2 = st.columns(2)
#Hvor
space = col1.markdown("##")
Where1 = col1.subheader("Hvor?")
Where2 = col2.text_input('Skriv hvor eventet foregår nedenfor', "Addresse", key="Address")

#Hvornår
col1, col2, col3,col4,col5 = st.columns(5)
space = col1.markdown("##")
When1 = col1.subheader("Hvornår")
When2 = col2.date_input('Fra Dato', key="FromDate")
When3 = col3.time_input('Klokken:', key="FromTime")
When4 = col4.date_input('Til Dato', key="ToDate")
When5 = col5.time_input('Klokken:', key="ToTime")


#tilmedlingsfrist
col1, col2 = st.columns(2)
space = col1.markdown("##")
Due1 = col1.subheader("Tilmeldingsfrist")
Due2 = col2.date_input('Angiv tilmeldingsfristen', key="DueDate")

## Kontaktinfo
st.header("")
st.header("")
st.header("Tilføj Kontaktoplysninger")
col1, col2, col3,col4 = st.columns(4)
col1.text_input("Firma", "DANSK HR", key="Firm")
col2.text_input("Addresse", "Brunbjergvej 10A", key="FirmAddress")
col3.text_input("Postnummer", "8240 Risskov", key="FirmZip")
col4.text_input("Land", "Danmark", key="FirmCountry")

col1, col2, col3 = st.columns(3)
col1.text_input("Kontaktperson", "Marianne M. Jensen", key="ContactPerson")
col2.text_input("E-mail (kontaktperson)", "mmj@danskhr.dk", key="ContactEmail")
col3.text_input("TelefonNummer (kontaktperson)", "86 21 61 11", key="ContactPhone")



## BILLETTER
st.header("")
st.header("")
st.header("Vælg antallet af billet-typer")
BT = st.slider('Slide for at vælge antallet af ønskede billet-typer', 0, 10, 1)


col1, col2 = st.columns(2)

for i in range(BT):
    BT1 = col1.text_input('Billet type {number}'.format(number=i+1), 'Navn på Billet-typen ', key="BT_type"+str(i+1))
    BT2 = col2.text_input('Billet type {number} pris (DKK)'.format(number=i+1), 'Skriv prisen på billetten i DKK', key="BT_price"+str(i+1))



## Felter
st.header("")
st.header("")
st.header("Vælg antallet af Tilmeldingsfelter")
F = st.slider('Slide for at vælge antallet af ønskede tilmeldingsfelter', 0, 20, 1)


col1, col2 = st.columns(2)

for i in range(F):
    F1 = col1.text_input('Felt {number}'.format(number=i+1), 'Skriv hvilket felt der ønskes her', key="F_type"+str(i+1))
    F2 = col2.selectbox('Er feltet påkrævet?'.format(number=i+1),("Ja","Nej"), key="F_req"+str(i+1))

#Fix for nested buttons
if "button_clicked" not in st.session_state:
    st.session_state.button_clicked = False
    
def button_callback():
    st.session_state.button_clicked = True
    
def button_callback_undo():
    '''
    Use as callback function for change in input functions above if desired nescessary
    '''
    st.session_state.button_clicked = False

## DONE
st.header("")
st.header("")
if st.button('Færdig', key="DoneButton") or st.session_state.button_clicked:
     st.header('Du har valgt:')
     st.subheader("Event-navn")
     st.write(st.session_state["EventName"])
     st.header("")
     st.subheader("Event-Beskrivelse")
     st.write(st.session_state["EventDescription"])
     st.header("")
     st.subheader("Praktiske Oplysninger")
     st.write("Eventet foregår på: " + st.session_state["Address"] + " fra den: " + str(st.session_state["FromDate"]) + " kl: " + str(st.session_state["FromTime"]) + " til den: " + str(st.session_state["ToDate"]) + " kl: " + str(st.session_state["ToTime"]))
     st.write("Tilmeldingsfristen er den: " + str(st.session_state["DueDate"]))
     st.header("")
     st.subheader("Kontakt-Oplysninger")
     st.write("Firma: " + st.session_state["Firm"] + ", Addresse: " + st.session_state["FirmAddress"] + ", " + st.session_state["FirmZip"] + ", " + st.session_state["FirmCountry"])
     st.write("Kontaktperson: " + st.session_state["ContactPerson"] + ", email: " + st.session_state["ContactEmail"] + ", telefon: " + st.session_state["ContactPhone"])
     st.header("")
     st.subheader("Billet-typer:")
     for i in range(BT):
        st.write(st.session_state["BT_type"+str(i+1)] + " til en pris på: " +st.session_state["BT_price"+str(i+1)] +" DKK")
     st.subheader("")
     st.subheader("Tilmeldingsfelter:")
     for i in range(F):
        msg = "Påkrævet" if st.session_state["F_req"+str(i+1)] == "Ja" else "Ikke påkrævet"
        st.write(st.session_state["F_type"+str(i+1)] + " som er: " + msg)
     st.header("")
     st.header("")
     st.header("")
     if st.button("Confirm", key="Confirm", on_click=button_callback):
        st.subheader("Du er Færdig!")
     else:
        st.subheader("Hvis informationerne ovenfor er korrekte, klik på 'Confirm', ellers ændre i formularerne ovenfor")
        
else:
     st.subheader('Tryk på færdig når formularen ovenfor er korrekt indtastet')

#st.write(st.session_state["DoneButton"])