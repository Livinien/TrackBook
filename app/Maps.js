import React, {useEffect, useState} from 'react';
import MapView, {Callout, Marker} from 'react-native-maps';
import { StyleSheet, View, Text } from 'react-native';
import { AntDesign } from '@expo/vector-icons';
import { Link } from 'expo-router';
import * as Location from 'expo-location';


// CARTE DE L'EMPLACEMENT DE LA BOITE À LIVRE
export default function App() {

    const [mapRegion, setMapRegion] = useState({
        latitude: 45.187717078351,
        longitude: 5.729055406837805,
        latitudeDelta: 0.0922,
        longitudeDelta: 0.0421,
    });

    const userLocation = async () => {
        let {status} = await Location.requestForegroundPermissionsAsync();
        if(status !== 'granted') {
            setErrorMsg('Permission to access location was denied');
        }
        
        let location = await Location.getCurrentPositionAsync({enableHightAccuracy: true});
        setMapRegion({
            latitude: location.coords.latitude,
            longitude: location.coords.longitude,
            latitudeDelta: 0.0922,
            longitudeDelta: 0.0421,
        });
        console.log(location.coords.latitude, location.coords.longitude);
    }

    useEffect(() => {
        userLocation();
    })

  return (
    <View style={styles.container}>
      <Link href={{ pathname: 'Profil', params: { pathname: 'Profil' }}} style={styles.link}><AntDesign style={styles.arrow} name="leftcircleo" size={50}/></Link>
      <MapView style={styles.map}
        region={mapRegion}
      >
        <Marker 
          coordinate={mapRegion} 
          title='Boite à Livre à Grand Place'>
          
          <Callout tooltip>
              <View>
                <View style={styles.bubble}>
                  <Link href={{ pathname: 'Box', params: { pathname: 'Box' }}}><Text style={styles.name}>Boite à livre Grand Place (Grenoble)</Text></Link>
                </View>
                <View style={styles.arrowBorder1}></View>
              </View>
          </Callout>
        </Marker>
      </MapView>
    </View>
  );
}


const styles = StyleSheet.create({

link: {
    position: 'absolute',
    top: 60,
    left: 20,
    zIndex: 10,
},

  map: {
    position: 'relative',
    width: '100%',
    height: '100%',
  },

  arrow: {
    color: "#fff",
  },

  bubble: {
    display: 'flex',
    alignItems: 'center',
    marginTop: 90,
    marginLeft: 25, 
    backgroundColor: '#fff',
    borderRadius: 6,
    borderColor: '#ccc',
    borderWidth: 0.5,
    padding: 15,
    width: 150
  },

  arrowBorder1: {
    backgroundColor: 'transparent',
    borderColor: 'transparent',
    borderTopColor: '#fff',
    borderWidth: 16,
    alignSelf: 'center',
    marginLeft: -10, 
    marginTop: -2,
  },

});
