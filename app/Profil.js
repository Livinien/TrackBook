import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, Pressable, Image } from 'react-native';
import { Link } from "expo-router";


// ACCÈS À LA PAGE PROFIL DE L'UTILISATEUR POUR SCANNER LE QRCODE DE LA BOX
export default function Button(props) {
  const { onPress, title = 'SCANNER VOTRE BOX' } = props;

  //const {id} = useSearchParams();

  const [users, setUser] = useState([]);
  const url = "https://tasty-signs-follow-193-252-172-28.loca.lt";

    useEffect(() => {
        fetch(url + "/api/v1/user/login?uuid=d4cab748-3224-49c3-a25d-4edfb39b1fd3"
            , {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Request-Method': 'GET',
                    'Access-Control-Request-Headers': 'Content-Type, Authorization'
                }})
            .then((response) => response.json())
            .then((json) => {
                setUser(json);
            })
            .catch((error) => console.error(error));
    }, []);


  return (
    <View style={styles.background}>
      <Text style={styles.title}>Bienvenue sur votre profil {users.prenom}</Text>
      <Text style={styles.subtitle}>Vous pouvez dès à présent scanner votre box</Text>
      <Image style={styles.image} source={require('../assets/images/profil.png')}/>
      <Pressable style={styles.maps}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'Box' }}} style={styles.text}>TROUVER VOTRE BOX</Link>
      </Pressable>
      <Pressable style={styles.button} onPress={onPress}>
        <Link href={{ pathname: 'QrcodeScan', params: { pathname: 'Box' }}} style={styles.text}>{title}</Link>
      </Pressable>
      <Pressable style={styles.previous}>
        <Link href={{ params: { pathname: 'index' }}} style={styles.text}>RETOURNEZ EN ARRIÈRE</Link>
      </Pressable>
    </View>
  );
}

const styles = StyleSheet.create({

  background: {
    backgroundColor: "#cdefff",
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
  },

  title: {
    marginTop: 140,
    fontSize: 20,
    fontWeight: "bold",
  },

  subtitle: {
    marginTop: 10,
    fontSize: 15,
    color: "#38434D",
  },

  image: {
    marginTop: 40,
    width: 380,
    height: 300,
    
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
    marginTop: 80,
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
