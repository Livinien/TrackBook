import React from 'react';
import { View, Text, StyleSheet, Pressable, Image } from 'react-native';
import { Link } from "expo-router";
import { FontAwesome5 } from '@expo/vector-icons';

// ACCUEIL DE L'APPLICATION
export default function Button(props) {
  const { onPress, title = 'CONNECTEZ-VOUS' } = props;
  return (
    <View style={styles.background}>
      <Text style={styles.title}>Box'Book</Text>
      <Text style={styles.subtitle}>Commencer à emprunter vos livres préférés.</Text>
      <Image style={styles.image} source={require('../assets/images/vector_books.png')}/>
      <Pressable style={styles.button} onPress={onPress}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'Profil' }}} style={styles.text}><FontAwesome5 name="user-alt" size={24}/> {title}</Link>
      </Pressable>
    </View>
  );
}


const styles = StyleSheet.create({

  background: {
    flex: 0,
    alignItems: "center",
    justifyContent: "center",
    height: 950,
    backgroundColor: "#cdefff",
  },

  title: {
    flex: 0,
    alignItems: "center",
    justifyContent: "center",
    marginTop: 70,
    fontSize: 54,
    fontWeight: "bold",
    shadowColor: "#000000",
        shadowOffset: {
          width: 0,
          height: 0,
        },
        shadowOpacity:  0.80,
        shadowRadius: 2.05,
  },

  subtitle: {
    fontSize: 15,
    marginTop: 20,
    fontWeight: 'bold',
    color: "#38434D",
  },

  image: {
    width: 375,
    height: 300,
    marginTop: 50,
  },

  button: {
    width: '66%',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#008fd1',
    padding: '2%',
    marginBottom: '50%',
    marginTop: '20%',
    borderRadius: '5%',
    elevation: 3,
    shadowColor: "#000000",
        shadowOffset: {
          width: 0,
          height: 0,
        },
        shadowOpacity:  0.99,
        shadowRadius: 3.05,
  },

  text: {
    fontSize: 20,
    fontWeight: 'bold',
    letterSpacing: 0.25,
    color: '#fff',
  },
});
