import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, Pressable } from 'react-native';
import { Link } from "expo-router";
import { Image } from 'expo-image';
import { useSearchParams } from "expo-router";
import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Ionicons } from '@expo/vector-icons';

// SCANNER UN AUTRE LIVRE
export default function Button(props) {
  const { onPress, title = 'RESCANNER UN LIVRE' } = props;
  const { id } = useSearchParams();

  const [book, setBook] = useState([]);
  const url = "https://clean-badgers-care-193-252-172-28.loca.lt";

    // EMPRUNTER UN LIVRE
    useEffect(() => {
        fetch(url + "/api/v1/book?id=1&idBook=" + id
            , {
                method:'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Request-Method': 'POST',
                    'Access-Control-Request-Headers': 'Content-Type, Authorization'
                }})
            .then((response) => response.json())
            .catch((error) => console.error(error));
    }, []);


    // AFFICHER LES CARACTÉRISTIQUES DU LIVRE
    useEffect(() => {
        fetch(url + "/api/v1/bookInfo?id=" + id
            , {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Request-Method': 'GET',
                    'Access-Control-Request-Headers': 'Content-Type, Authorization'
                }})
            .then((response) => response.json())
            .then((json) => {
                setBook(json);
            })
            .catch((error) => console.error(error));
    }, []);

  return (
    <View style={styles.background}>
      <Text style={styles.title1}>Vous avez scanner le livre :</Text>
      <Text style={styles.title2}>{book.title}</Text>
      <Image style={styles.image} source={"https://clean-badgers-care-193-252-172-28.loca.lt/assets/uploads/" + book.cover}/>
      <Pressable style={styles.maps}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'ReturnBook' }}} style={styles.text}><MaterialCommunityIcons name="book-arrow-left" size={24}/> RENDRE UN LIVRE</Link>
      </Pressable>
      <Pressable style={styles.button} onPress={onPress}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'Book' }}} style={styles.text}><MaterialCommunityIcons name="book-open-variant" size={24}/> {title}</Link>
      </Pressable>
      <Pressable style={styles.previous}>
        <Link href={{ pathname: 'Box', params: { pathname: 'Box' }}} style={styles.text}><Ionicons name="ios-arrow-back-circle-sharp" size={24}/> RETOUR EN ARRIÈRE</Link>
      </Pressable>
    </View>
  );
}

const styles = StyleSheet.create({

  background: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: "#cdefff",
  },

  title1: {
    marginTop: 110,
    fontSize: 20,
    fontWeight: "bold",
  },

  title2: {
    marginTop: 30,
    fontSize: 20,
    fontWeight: "bold",
  },

  subtitle: {
    fontSize: 15,
    color: "#38434D",
  },

  image: {
    width: 300,
    height: 330,
    marginTop: 25,
    borderRadius: '5%',
  },

  button: {
    width: '76%',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#008fd1',
    padding: '2%',
    marginBottom: '50%',
    marginTop: '9%',
    borderRadius: '5%',
    padding: 10,
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

  maps: {
    width: 285,
    fontSize: 20,
    fontWeight: 'bold',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: -5,
    marginTop: 35,
    padding: 10,
    letterSpacing: 0.25,
    backgroundColor: '#9957ff',
    color: '#fff',
    borderRadius: 5,
    shadowColor: "#000000",
        shadowOffset: {
          width: 0,
          height: 0,
        },
        shadowOpacity:  0.99,
        shadowRadius: 3.05,
  },

  previous: {
    width: 285,
    fontSize: 20,
    fontWeight: 'bold',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 95,
    marginTop: -160,
    padding: 10,
    letterSpacing: 0.25,
    backgroundColor: 'green',
    color: '#fff',
    borderRadius: 5,
    shadowColor: "#000000",
        shadowOffset: {
          width: 0,
          height: 0,
        },
        shadowOpacity:  0.99,
        shadowRadius: 3.05,
  },
});
