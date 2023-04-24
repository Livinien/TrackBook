import React, { useState, useEffect } from 'react';
import { Text, View, StyleSheet } from 'react-native';
import { BarCodeScanner } from 'expo-barcode-scanner';
import { useRouter, useSearchParams } from "expo-router";
import { AntDesign } from '@expo/vector-icons';
import { Link } from 'expo-router';


// ACCÉDER AU PROFIL DE L'UTILISATEUR VIA LE QRCODE
export default function App() {
  const [hasPermission, setHasPermission] = useState(null);
  const [scanned, setScanned] = useState(false);
  const {pathname} = useSearchParams();
  const router = useRouter();

  useEffect(() => {
    const getBarCodeScannerPermissions = async () => {
      const { status } = await BarCodeScanner.requestPermissionsAsync();
      setHasPermission(status === 'granted');
    };

    getBarCodeScannerPermissions();
  }, []);

  const handleBarCodeScanned = ({ type, data }) => {
    setScanned(true);
    router.push({ pathname: pathname, params: { id: data } });
  };

  if (hasPermission === null) {
    return <Text>Autoriser la caméra</Text>;
  }
  if (hasPermission === false) {
    return <Text>Vous n'avez pas accès à la caméra</Text>;
  }

  return (
    <View style={styles.container}>
      <Link href={{ params: { pathname: 'index' }}} style={styles.previous}><AntDesign style={styles.arrow} name="arrowleft" size={34} color="#fff"/> MENU PRINCIPAL</Link>

      <BarCodeScanner
        onBarCodeScanned={scanned ? undefined : handleBarCodeScanned}
        style={StyleSheet.absoluteFillObject}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    display: 'flex',
    flexDirection: 'row',
    flex: 1,
    flexDirection: 'column',
    justifyContent: 'center',
    color: '#fff',
  },

  arrow: {
    display: 'flex',
    alignItems: 'center',
    marginTop: 50,
  },

  previous: {
    position: 'absolute',
    top: 70,
    left: 20,
    zIndex: 10,
    fontSize: 30,
    fontWeight: 'bold',
    color: '#fff',
  },

});

