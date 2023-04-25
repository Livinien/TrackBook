import React, {useEffect, useState} from 'react';
import MapView, {Callout, Marker} from 'react-native-maps';
import { StyleSheet, View, Text, Image } from 'react-native';
import { AntDesign } from '@expo/vector-icons';
import { Link } from 'expo-router';
import * as Location from 'expo-location';


// CARTE DE L'EMPLACEMENT DE LA BOITE À LIVRE
export default function App() {

  const [markers, setMarker] = useState([]);
  const url = "https://nine-peaches-argue-193-252-172-28.loca.lt";

    useEffect(() => {
        fetch(url + "/api/v1/box/get"
            , {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Request-Method': 'GET',
                    'Access-Control-Request-Headers': 'Content-Type, Authorization'
                }})
            .then((response) => response.json())
            .then((json) => {

              const markers = [];
              for (let i = 0; i < json.length; i++) {
                  const box = json[i];
                  const marker = {
                      latlng: {
                          latitude: box.geoLoc['1'],
                          longitude: box.geoLoc['2']
                      },
                      title: box.street + ', ' + box.zipcode + ' ' + box.city,
                      capacity: box.capacity,
                      id: box.id
                  }
                  markers.push(marker);
              }
                setMarker(markers);
            })
            .catch((error) => console.error(error));
    }, []);
    console.log(markers);



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
        {markers.map(marker => (
        <Marker key={marker.id}
                    coordinate={{
                        latitude: parseFloat(marker.latlng.latitude),
                        longitude: parseFloat(marker.latlng.longitude),}}
                  
                    description={'Capacity: ' + marker.capacity} >

            <Callout tooltip>
              <View>
                <View style={styles.bubble}>
                  <Link href={{ pathname: 'MarkerMaps', params: { pathname: 'MarkerMaps', street: marker.title }}}><Text style={styles.name}>{marker.title}</Text></Link>
                  
                  <Link href={{ pathname: 'MarkerMaps', params: { pathname: 'MarkerMaps', street: marker.title }}} style={styles.imageLink}><Image 
                  style={styles.image}
                  source={require('../assets/images/markerImage.png')}
                  /></Link>
                  
                </View>
                <View style={styles.arrowBorder1}></View>
              </View>
          </Callout>
        </Marker>
      ))}
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

  name: {
    marginTop: 10,
    height: 100,
  },

  imageLink: {
    marginTop: 10,
    borderRadius: 5,
  },

  image: {
    marginTop: 10,
    width: 120,
    height: 100,
    borderRadius: 5,
  },
});
