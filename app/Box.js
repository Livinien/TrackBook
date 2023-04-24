import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, Pressable, Image } from 'react-native';
import { Link } from "expo-router";
import { useSearchParams } from "expo-router";
import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Ionicons } from '@expo/vector-icons';

// SCANNER LA BOÎTE À LIVRE
export default function Button(props) {
  const { onPress, title = 'EMPRUNTER UN LIVRE' } = props;
  const { id } = useSearchParams();


  const [box, setBox] = useState([]);
  const url = "https://rude-birds-float-193-252-172-28.loca.lt";

    useEffect(() => {
        fetch(url + "/api/v1/box/" + id
            , {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Request-Method': 'GET',
                    'Access-Control-Request-Headers': 'Content-Type, Authorization'
                }})
            .then((response) => response.json())
            .then((json) => {
                setBox(json);
            })
            .catch((error) => console.error(error));
    }, []);


  return (
    <View style={styles.background}>
      <Text style={styles.title}>Vous avez scanner la box :</Text>
      <Text style={styles.subtitle1}>{box.street} {box.city} {box.zipcode}</Text>
      <Image style={styles.image} source={require('../assets/images/boite_a_livre.png')}/>
      <Text style={styles.subtitle2}>Vous pouvez dès à présent scanner votre livre</Text>
      <Pressable style={styles.maps}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'ReturnBook' }}} style={styles.text}><MaterialCommunityIcons name="book-arrow-left" size={24}/> RENDRE UN LIVRE</Link>
      </Pressable>
      <Pressable style={styles.button} onPress={onPress}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'Book' }}} style={styles.text}><MaterialCommunityIcons name="book-open-variant" size={24}/> {title}</Link>
      </Pressable>
      <Pressable style={styles.previous}>
        <Link href={{ pathname: 'Profil', params: { pathname: 'Profil' }}} style={styles.text}><Ionicons name="ios-arrow-back-circle-sharp" size={24}/> RETOUR EN ARRIÈRE</Link>
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

  title: {
    marginTop: 130,
    marginBottom: 20,
    fontSize: 20,
    fontWeight: "bold",
  },

  subtitle1: {
    marginBottom: 10,
    fontSize: 15,
    fontWeight: "bold",
    color: "#38434D",
  },

  subtitle2: {
    marginTop: 20,
    fontSize: 15,
    fontWeight: 'bold',
    color: "#38434D",
  },

  image: {
    width: 400,
    height: 300,
    marginTop: 10,
    marginLeft: 37,
  },

  button: {
    width: '76%',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#008fd1',
    padding: '2%',
    marginBottom: '50%',
    marginTop: '30%',
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
    marginBottom: -85,
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
