// const url = "https://shahid1.infinityfreeapp.com/api/posts";
// const url = "https://shahid1.infinityfreeapp.com/api/friends";
//* react native tutorial
// Start hare
{
  // using fetch
  const getAPIData = async () => {
    const url = "https://shahid1.infinityfreeapp.com/api/friends";
    console.warn("Fetching data from: ", url); // Log the URL being used

    try {
      let result = await fetch(url);
      if (!result.ok) {
        // Handle non-2xx responses (e.g., 404, 500)
        throw new Error(`HTTP error! Status: ${result.status}`);
      }
      result = await result.json();
      console.warn(result); // Log the result to the console
      setData(result); // Set the state with the fetched data
    } catch (error) {
      // Catch any errors (network issues, invalid responses, etc.)
      console.error("Error fetching data:", error);
      // Optionally, you can set an error state here to display an error message to the user
    }
  };

  // using axios
  import axios from 'axios';

  const getAPIData = async () => {
    const url = "https://shahid1.infinityfreeapp.com/api/friends";
    console.warn("Fetching data from: ", url); // Log the URL being used

    try {
      const result = await axios.get(url);
      console.warn(result.data); // Log the data from the API response
      setData(result.data); // Set the data
    } catch (error) {
      // Catch and log any errors
      console.error("Error fetching data:", error);
      setError("Failed to load data. Please check your network connection.");
    }
  };

  // display data in original formate / json formate in cmd me 

  const getAPIData = async () => {
    const url = "https://jsonplaceholder.typicode.com/users";
    let result = await fetch(url);
    result = await result.json();
    console.log(JSON.stringify(result, null, 2)); // This will log the JSON data with pretty formatting
    setData(result);
  };


}
//*
// Start hare
{


}
// Start hare
{

}
//*
// Start hare
{

}
// regarding icon
{
  import React from 'react';
import {NavigationContainer} from '@react-navigation/native';
// import {createBottomTabNavigator} from '@react-navigation/bottom-tabs';
import {StyleSheet} from 'react-native';
import {
  createDrawerNavigator,
  DrawerContentScrollView,
  DrawerItemList,
} from '@react-navigation/drawer';
import Icon from 'react-native-vector-icons/MaterialIcons';
import Home from './components/HomeScreen';
import About from './components/AboutScreen';
import Resume from './components/ResumeScreen';
// import Portfolio from './components/PortfolioScreen';
import PortfolioStack from './components/PortfolioScreen';
import Contact from './components/ContactScreen';
import Settings from './components/SettingsScreen';

// // Custom Drawer Content with Image
// function CustomDrawerContent(props) {
//   const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg'); // Update the path if needed
//   return (
//     <DrawerContentScrollView {...props}>
//       <View style={styles.header}>
//         <Image source={defaultImage} style={styles.image} />
//         <Text style={styles.title}>My App</Text>
//       </View>
//       <DrawerItemList {...props} />
//     </DrawerContentScrollView>
//   );
// }
const Drawer = createDrawerNavigator();

// function App() {
//   return (
//     <NavigationContainer>
//       <Drawer.Navigator initialRouteName="Home">
//         <Drawer.Screen name="Home" component={Home} />
//         <Drawer.Screen name="About" component={About} />
//         <Drawer.Screen name="Resume" component={Resume} />
//         <Drawer.Screen name="Portfolio" component={PortfolioStack} />
//         <Drawer.Screen name="Contact" component={Contact} />
//         <Drawer.Screen name="Settings" component={Settings} />
//       </Drawer.Navigator>
//     </NavigationContainer>
//   );
// }

function App() {
  return (
    <NavigationContainer>
      <Drawer.Navigator
        initialRouteName="Home"
        screenOptions={{
          drawerStyle: styles.drawerStyle,
          drawerLabelStyle: styles.drawerLabel,
          drawerActiveTintColor: '#fff',
          drawerInactiveTintColor: '#000',
          drawerActiveBackgroundColor: '#6200ea',
          drawerItemStyle: styles.drawerItem,
        }}>
        <Drawer.Screen name="Home" component={Home} />
        <Drawer.Screen name="About" component={About} />
        <Drawer.Screen name="Resume" component={Resume} />
        <Drawer.Screen name="Portfolio" component={PortfolioStack} />
        <Drawer.Screen name="Contact" component={Contact} />
        <Drawer.Screen name="Settings" component={Settings} />
      </Drawer.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  drawerStyle: {
    backgroundColor: '#f5f5f5',
    width: 240,
  },
  drawerLabel: {
    fontSize: 16,
    fontWeight: 'bold',
  },
  drawerItem: {
    marginVertical: 5,
    borderRadius: 5,
  },
  // screen: {
  //   flex: 1,
  //   justifyContent: 'center',
  //   alignItems: 'center',
  // },
});

export default App;

}
{
  import React from 'react';
  import { View, Text, StyleSheet, Image } from 'react-native';
  import {
    createDrawerNavigator,
    DrawerContentScrollView,
    DrawerItemList,
  } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';
  import Icon from 'react-native-vector-icons/MaterialIcons'; // Make sure you have this library installed

  function HomeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Home Screen</Text>
        <Icon name="home" size={24} color="blue" />
      </View>
    );
  }

  function AboutScreen() {
    return (
      <View style={styles.screen}>
        <Text>About Screen</Text>
      </View>
    );
  }

  // Custom Drawer Content with Image
  function CustomDrawerContent(props) {
    const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg'); // Update the path if needed
    return (
      <DrawerContentScrollView {...props}>
        <View style={styles.header}>
          <Image source={defaultImage} style={styles.image} />
          <Text style={styles.title}>My App</Text>
        </View>
        <DrawerItemList {...props} />
      </DrawerContentScrollView>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator
          initialRouteName="Home"
          drawerContent={props => <CustomDrawerContent {...props} />}
          screenOptions={{
            drawerStyle: styles.drawerStyle,
            drawerLabelStyle: styles.drawerLabel,
            drawerActiveTintColor: '#fff',
            drawerInactiveTintColor: '#000',
            drawerActiveBackgroundColor: '#6200ea',
            drawerItemStyle: styles.drawerItem,
          }}>
          <Drawer.Screen
            name="Home"
            component={HomeScreen}
            options={{
              drawerIcon: ({ color, size }) => (
                <Icon name="home" color={color} size={size} />
              ),
            }}
          />
          <Drawer.Screen
            name="About"
            component={AboutScreen}
            options={{
              drawerIcon: ({ color, size }) => (
                <Icon name="info" color={color} size={size} />
              ),
            }}
          />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    header: {
      padding: 20,
      backgroundColor: '#6200ea',
      alignItems: 'center',
      marginBottom: 10,
    },
    image: {
      width: 80,
      height: 80,
      borderRadius: 40,
      marginBottom: 10,
    },
    title: {
      color: '#fff',
      fontSize: 18,
      fontWeight: 'bold',
    },
    drawerStyle: {
      backgroundColor: '#f5f5f5',
      width: 240,
    },
    drawerLabel: {
      fontSize: 16,
      fontWeight: 'bold',
    },
    drawerItem: {
      marginVertical: 5,
      borderRadius: 5,
    },
    screen: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;

}
{
  import React from 'react';
  import { View, Text, StyleSheet, Image } from 'react-native';
  import {
    createDrawerNavigator,
    DrawerContentScrollView,
    DrawerItemList,
  } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';
  import Icon from 'react-native-vector-icons/MaterialIcons'; // Make sure you have this library installed

  function HomeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Home Screen</Text>
        <Icon name="home" size={24} color="blue" />
      </View>
    );
  }

  function AboutScreen() {
    return (
      <View style={styles.screen}>
        <Text>About Screen</Text>
      </View>
    );
  }

  // Custom Drawer Content with Image
  function CustomDrawerContent(props) {
    const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg'); // Update the path if needed
    return (
      <DrawerContentScrollView {...props}>
        <View style={styles.header}>
          <Image source={defaultImage} style={styles.image} />
          <Text style={styles.title}>My App</Text>
        </View>
        <DrawerItemList {...props} />
      </DrawerContentScrollView>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator
          initialRouteName="Home"
          drawerContent={props => <CustomDrawerContent {...props} />}
          screenOptions={{
            drawerStyle: styles.drawerStyle,
            drawerLabelStyle: styles.drawerLabel,
            drawerActiveTintColor: '#fff',
            drawerInactiveTintColor: '#000',
            drawerActiveBackgroundColor: '#6200ea',
            drawerItemStyle: styles.drawerItem,
          }}>
          <Drawer.Screen
            name="Home"
            component={HomeScreen}
            options={{
              drawerIcon: ({ color, size }) => (
                <Icon name="home" color={color} size={size} />
              ),
            }}
          />
          <Drawer.Screen
            name="About"
            component={AboutScreen}
            options={{
              drawerIcon: ({ color, size }) => (
                <Icon name="info" color={color} size={size} />
              ),
            }}
          />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    header: {
      padding: 20,
      backgroundColor: '#6200ea',
      alignItems: 'center',
      marginBottom: 10,
    },
    image: {
      width: 80,
      height: 80,
      borderRadius: 40,
      marginBottom: 10,
    },
    title: {
      color: '#fff',
      fontSize: 18,
      fontWeight: 'bold',
    },
    drawerStyle: {
      backgroundColor: '#f5f5f5',
      width: 240,
    },
    drawerLabel: {
      fontSize: 16,
      fontWeight: 'bold',
    },
    drawerItem: {
      marginVertical: 5,
      borderRadius: 5,
    },
    screen: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;

}
// regarding navigation template
{
  import React from 'react';
  import { View, Text, StyleSheet, Image } from 'react-native';
  import {
    createDrawerNavigator,
    DrawerContentScrollView,
    DrawerItemList,
  } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';

  function HomeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Home Screen</Text>
      </View>
    );
  }

  function AboutScreen() {
    return (
      <View style={styles.screen}>
        <Text>About Screen</Text>
      </View>
    );
  }

  function ResumeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Resume Screen</Text>
      </View>
    );
  }

  function PortfolioScreen() {
    return (
      <View style={styles.screen}>
        <Text>Portfolio Screen</Text>
      </View>
    );
  }

  function ContactScreen() {
    return (
      <View style={styles.screen}>
        <Text>Contact Screen</Text>
      </View>
    );
  }

  function SettingsScreen() {
    return (
      <View style={styles.screen}>
        <Text>Settings Screen</Text>
      </View>
    );
  }

  // Custom Drawer Content with Image
  function CustomDrawerContent(props) {
    const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg'); // Update the path if needed
    return (
      <DrawerContentScrollView {...props}>
        <View style={styles.header}>
          <Image source={defaultImage} style={styles.image} />
          <Text style={styles.title}>My App</Text>
        </View>
        <DrawerItemList {...props} />
      </DrawerContentScrollView>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator
          initialRouteName="Home"
          drawerContent={props => <CustomDrawerContent {...props} />}
          screenOptions={{
            drawerStyle: styles.drawerStyle,
            drawerLabelStyle: styles.drawerLabel,
            drawerActiveTintColor: '#fff',
            drawerInactiveTintColor: '#000',
            drawerActiveBackgroundColor: '#6200ea',
            drawerItemStyle: styles.drawerItem,
          }}>
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="About" component={AboutScreen} />
          <Drawer.Screen name="Resume" component={ResumeScreen} />
          <Drawer.Screen name="Portfolio" component={PortfolioScreen} />
          <Drawer.Screen name="Contact" component={ContactScreen} />
          <Drawer.Screen name="Settings" component={SettingsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    header: {
      padding: 20,
      backgroundColor: '#6200ea',
      alignItems: 'center',
      marginBottom: 10,
    },
    image: {
      width: 80,
      height: 80,
      borderRadius: 40,
      marginBottom: 10,
    },
    title: {
      color: '#fff',
      fontSize: 18,
      fontWeight: 'bold',
    },
    drawerStyle: {
      backgroundColor: '#f5f5f5',
      width: 240,
    },
    drawerLabel: {
      fontSize: 16,
      fontWeight: 'bold',
    },
    drawerItem: {
      marginVertical: 5,
      borderRadius: 5,
    },
    screen: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;

}
// regarding navigation template
{
  import React from 'react';
  import { View, Text, StyleSheet, Image } from 'react-native';
  import {
    createDrawerNavigator,
    DrawerContentScrollView,
    DrawerItemList,
  } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';

  function HomeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Home Screen</Text>
      </View>
    );
  }

  function AboutScreen() {
    return (
      <View style={styles.screen}>
        <Text>About Screen</Text>
      </View>
    );
  }

  function ResumeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Resume Screen</Text>
      </View>
    );
  }

  function PortfolioScreen() {
    return (
      <View style={styles.screen}>
        <Text>Portfolio Screen</Text>
      </View>
    );
  }

  function ContactScreen() {
    return (
      <View style={styles.screen}>
        <Text>Contact Screen</Text>
      </View>
    );
  }

  function SettingsScreen() {
    return (
      <View style={styles.screen}>
        <Text>Settings Screen</Text>
      </View>
    );
  }

  // Custom Drawer Content
  function CustomDrawerContent(props) {
    const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg');
    return (
      <DrawerContentScrollView {...props}>
        <View style={styles.header}>
          <Image source={defaultImage} style={[styles.image]} />
          <Text style={styles.title}>My App</Text>
        </View>
        <DrawerItemList {...props} />
      </DrawerContentScrollView>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator
          initialRouteName="Home"
          drawerContent={props => <CustomDrawerContent {...props} />}
          screenOptions={{
            drawerStyle: styles.drawerStyle,
            drawerLabelStyle: styles.drawerLabel,
            drawerActiveTintColor: '#fff',
            drawerInactiveTintColor: '#000',
            drawerActiveBackgroundColor: '#6200ea',
            drawerItemStyle: styles.drawerItem,
          }}>
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="About" component={AboutScreen} />
          <Drawer.Screen name="Resume" component={ResumeScreen} />
          <Drawer.Screen name="Portfolio" component={PortfolioScreen} />
          <Drawer.Screen name="Contact" component={ContactScreen} />
          <Drawer.Screen name="Settings" component={SettingsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    header: {
      padding: 20,
      backgroundColor: '#6200ea',
      alignItems: 'center',
    },
    title: {
      color: '#fff',
      fontSize: 18,
      fontWeight: 'bold',
    },
    drawerStyle: {
      backgroundColor: '#f5f5f5',
      width: 240,
    },
    drawerLabel: {
      fontSize: 16,
      fontWeight: 'bold',
    },
    drawerItem: {
      marginVertical: 5,
      borderRadius: 5,
    },
    screen: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    // profile image
    image: {
      width: 100,
      height: 100,
      borderRadius: 50,
      marginVertical: 16,
      borderWidth: 2,
      borderColor: '#6200ee',
    },
  });
  export default App;

}
// regarding navigation template
{
  import React from 'react';
  import { View, Text, StyleSheet } from 'react-native';
  import {
    createDrawerNavigator,
    DrawerContentScrollView,
    DrawerItemList,
  } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';

  function HomeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Home Screen</Text>
      </View>
    );
  }

  function AboutScreen() {
    return (
      <View style={styles.screen}>
        <Text>About Screen</Text>
      </View>
    );
  }

  function ResumeScreen() {
    return (
      <View style={styles.screen}>
        <Text>Resume Screen</Text>
      </View>
    );
  }

  function PortfolioScreen() {
    return (
      <View style={styles.screen}>
        <Text>Portfolio Screen</Text>
      </View>
    );
  }

  function ContactScreen() {
    return (
      <View style={styles.screen}>
        <Text>Contact Screen</Text>
      </View>
    );
  }

  function SettingsScreen() {
    return (
      <View style={styles.screen}>
        <Text>Settings Screen</Text>
      </View>
    );
  }

  // Custom Drawer Content
  function CustomDrawerContent(props) {
    return (
      <DrawerContentScrollView {...props}>
        <View style={styles.header}>
          <Text style={styles.title}>My App</Text>
        </View>
        <DrawerItemList {...props} />
      </DrawerContentScrollView>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator
          initialRouteName="Home"
          drawerContent={props => <CustomDrawerContent {...props} />}
          screenOptions={{
            drawerStyle: styles.drawerStyle,
            drawerLabelStyle: styles.drawerLabel,
            drawerActiveTintColor: '#fff',
            drawerInactiveTintColor: '#000',
            drawerActiveBackgroundColor: '#6200ea',
            drawerItemStyle: styles.drawerItem,
          }}>
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="About" component={AboutScreen} />
          <Drawer.Screen name="Resume" component={ResumeScreen} />
          <Drawer.Screen name="Portfolio" component={PortfolioScreen} />
          <Drawer.Screen name="Contact" component={ContactScreen} />
          <Drawer.Screen name="Settings" component={SettingsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    header: {
      padding: 20,
      backgroundColor: '#6200ea',
      alignItems: 'center',
    },
    title: {
      color: '#fff',
      fontSize: 18,
      fontWeight: 'bold',
    },
    drawerStyle: {
      backgroundColor: '#f5f5f5',
      width: 240,
    },
    drawerLabel: {
      fontSize: 16,
      fontWeight: 'bold',
    },
    drawerItem: {
      marginVertical: 5,
      borderRadius: 5,
    },
    screen: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });
  export default App;

}
//* regarding calculater app
// Start hare
{

  import React, { useState } from 'react';
  import { Button, Text, TextInput, View, StyleSheet } from 'react-native';

  const App = () => {
    // State to hold the values of the input fields
    const [input1, setInput1] = useState('');
    const [input2, setInput2] = useState('');
    const [input3, setInput3] = useState('');

    // Function to handle button press
    const handlePress = () => {
      // Convert input values to numbers and calculate the total
      const num1 = parseFloat(input1) || 0;
      const num2 = parseFloat(input2) || 0;
      const total = num1 + num2;
      // console.warn(total);
      // alert(total);
      // Update input3 with the total value
      setInput3(total.toString());
    };

    return (
      <View style={styles.container}>
        <Text style={styles.text}>first Application</Text>
        <Text style={styles.label}>Enter first value to add</Text>
        <TextInput
          style={styles.input}
          placeholder="Enter first value"
          keyboardType="numeric"
          value={input1}
          onChangeText={setInput1}
        />
        <Text style={styles.label}>Enter second value to add</Text>
        <TextInput
          style={styles.input}
          placeholder="Enter second value"
          keyboardType="numeric"
          value={input2}
          onChangeText={setInput2}
        />
        <Text style={styles.text}>Total</Text>
        <TextInput
          style={styles.input}
          placeholder="Total will be displayed here"
          value={input3}
          editable={false} // Prevent user from editing this field
        />
        <Button title="Calculate Total" onPress={handlePress} />
      </View>
    );
  };

  // Styles for the components
  const styles = StyleSheet.create({
    container: {
      // backgroundColor:'gray',
      flex: 1,
      padding: 16,
      justifyContent: 'center',
    },
    text: {
      // color:'white',
      fontSize: 30,
      marginBottom: 10,
    },
    label: {
      // color:'white',
      fontSize: 15,
      marginBottom: 10,
    },
    input: {
      height: 40,
      color: 'red',
      borderColor: 'black',
      borderWidth: 1,
      marginBottom: 16,
      paddingHorizontal: 8,
    },
  });

  export default App;
}


//* regarding portfolio
// Start hare

{
  // App.js

  import React from 'react';
  import { NavigationContainer } from '@react-navigation/native';
  import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
  import Home from './components/Home';
  import Profile from './components/Profile';
  import Settings from './components/Settings';

  const Tab = createBottomTabNavigator();

  const App = () => {
    return (
      <NavigationContainer>
        <Tab.Navigator
          screenOptions={{
            headerStyle: { backgroundColor: '#6200ee' },
            headerTintColor: '#fff',
            tabBarStyle: { backgroundColor: '#6200ee' },
            tabBarActiveTintColor: '#fff',
            tabBarInactiveTintColor: '#ddd',
          }}>
          <Tab.Screen name="Home" component={Home} />
          <Tab.Screen name="Profile" component={Profile} />
          <Tab.Screen name="Settings" component={Settings} />
        </Tab.Navigator>
      </NavigationContainer>
    );
  };

  export default App;

}

// Start hare
{
  import * as React from 'react';
  import {
    Text,
    View,
    Button,
    StyleSheet,
    Image,
    TouchableOpacity,
  } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

  function HomeScreen({ navigation }) {
    const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg');
    return (
      <View style={[styles.contentcenter]}>
        <Text style={styles.heading}>Welcome to My Portfolio</Text>
        <Image source={defaultImage} style={[styles.image]} />
        <View style={styles.buttonGroup}>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('About')}>
            <Text style={styles.buttonText}>About</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('Resume')}>
            <Text style={styles.buttonText}>Resume</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('Portfolio')}>
            <Text style={styles.buttonText}>Portfolio</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('Contact')}>
            <Text style={styles.buttonText}>Contact</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('Settings')}>
            <Text style={styles.buttonText}>Go to Settings</Text>
          </TouchableOpacity>
        </View>
      </View>
    );
  }

  function SettingsScreen({ navigation }) {
    return (
      <View style={[styles.contentcenter]}>
        <TouchableOpacity
          style={styles.button}
          onPress={() => navigation.navigate('Home')}>
          <Text style={styles.buttonText}>Go to Home</Text>
        </TouchableOpacity>
      </View>
    );
  }

  function AboutScreen({ navigation }) {
    return (
      <View style={[styles.contentcenter]}>
        <Text style={styles.heading}>About Me</Text>
        <TouchableOpacity
          style={styles.button}
          onPress={() => navigation.navigate('Home')}>
          <Text style={styles.buttonText}>Go to Home</Text>
        </TouchableOpacity>
      </View>
    );
  }

  function ResumeScreen({ navigation }) {
    return (
      <View style={[styles.contentcenter]}>
        <Text style={styles.heading}>My Resume</Text>
        <TouchableOpacity
          style={styles.button}
          onPress={() => navigation.navigate('Home')}>
          <Text style={styles.buttonText}>Go to Home</Text>
        </TouchableOpacity>
      </View>
    );
  }

  function PortfolioScreen({ navigation }) {
    return (
      <View style={[styles.contentcenter]}>
        <Text style={styles.heading}>My Portfolio</Text>
        <TouchableOpacity
          style={styles.button}
          onPress={() => navigation.navigate('Home')}>
          <Text style={styles.buttonText}>Go to Home</Text>
        </TouchableOpacity>
      </View>
    );
  }

  function ContactScreen({ navigation }) {
    return (
      <View style={[styles.contentcenter]}>
        <Text style={styles.heading}>Contact Me</Text>
        <TouchableOpacity
          style={styles.button}
          onPress={() => navigation.navigate('Home')}>
          <Text style={styles.buttonText}>Go to Home</Text>
        </TouchableOpacity>
      </View>
    );
  }

  const Tab = createBottomTabNavigator();
  function App() {
    return (
      <NavigationContainer>
        <Tab.Navigator
          screenOptions={{
            headerStyle: { backgroundColor: '#6200ee' },
            headerTintColor: '#fff',
            tabBarStyle: { backgroundColor: '#6200ee' },
            tabBarActiveTintColor: '#fff',
            tabBarInactiveTintColor: '#ddd',
          }}>
          <Tab.Screen name="Home" component={HomeScreen} />
          <Tab.Screen name="About" component={AboutScreen} />
          <Tab.Screen name="Resume" component={ResumeScreen} />
          <Tab.Screen name="Portfolio" component={PortfolioScreen} />
          <Tab.Screen name="Contact" component={ContactScreen} />
          <Tab.Screen name="Settings" component={SettingsScreen} />
        </Tab.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    // image
    image: {
      width: 100,
      height: 100,
      borderRadius: 50,
      marginVertical: 16,
      borderWidth: 2,
      borderColor: '#6200ee',
    },

    // content center
    contentcenter: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      backgroundColor: '#f5f5f5',
      paddingHorizontal: 16,
    },

    heading: {
      fontSize: 24,
      fontWeight: 'bold',
      color: '#333',
      marginBottom: 16,
    },

    buttonGroup: {
      width: '100%',
      alignItems: 'center',
      marginTop: 16,
    },

    button: {
      backgroundColor: '#6200ee',
      paddingVertical: 12,
      paddingHorizontal: 24,
      borderRadius: 8,
      marginVertical: 8,
      width: '90%',
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.3,
      shadowRadius: 3,
      elevation: 4,
    },

    buttonText: {
      color: '#fff',
      fontSize: 16,
      fontWeight: 'bold',
    },
  });

  export default App;

}
//* temprary

// Start hare
{

  import React, { useEffect, useState } from 'react';
  import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

  const App = () => {
    const [data, setData] = useState([]);
    const [modalVisible, setModalVisible] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [name, setName] = useState('');
    const [color, setColor] = useState('');
    const [searchText, setSearchText] = useState('');

    const getAPIData = async () => {
      const url = "https://jsonplaceholder.typicode.com/users";
      // const url = "https://shahid1.infinityfreeapp.com/api/posts";
      // const url = "https://shahid1.infinityfreeapp.com/api/friends"
      let result = await fetch(url);
      result = await result.json();
      console.warn(result);
      setData(result);
    };


    useEffect(() => {
      getAPIData();
    }, []);

    const deleteUser = async (id) => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${id}`, {
        method: "DELETE"
      });
      result = await result.json();
      if (result) {
        console.warn("User deleted");
        getAPIData();
      }
    }

    const updateUser = async () => {
      if (!selectedUser) return;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${selectedUser.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, color })
      });
      result = await result.json();
      if (result) {
        console.warn("User updated");
        setModalVisible(false);
        getAPIData();
      }
    }

    // const searchUser = async (text) => {
    //   setSearchText(text);
    //   const url = `http://10.0.2.2:3000/users?q=${text}`;
    //   let result = await fetch(url);
    //   result = await result.json();
    //   console.warn("Search result:", result); // Log the result for debugging
    //   setData(result);
    // }

    const searchUser = async (text) => {
      setSearchText(text);
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      // Filter data based on search text
      const filteredData = result.filter(user =>
        user.name.toLowerCase().includes(text.toLowerCase()) ||
        user.color.toLowerCase().includes(text.toLowerCase())
      );
      // Set filtered data
      setData(filteredData);
    }


    const openModal = (user) => {
      setSelectedUser(user);
      setName(user.name);
      setColor(user.color);
      setModalVisible(true);
    }

    return (
      <View style={styles.container}>
        <View>
          <TextInput
            style={styles.input}
            placeholder="Search"
            value={searchText}
            onChangeText={(text) => searchUser(text)}
          />
        </View>

        <ScrollView>
          {data.length ? (
            data.map((item) => (
              <View key={item.id} style={styles.itemContainer}>
                <Text style={styles.itemText}>IDs: {item.id}</Text>
                <Text style={styles.itemText}>Name: {item.name}</Text>
                <Text style={styles.itemText}>Color: {item.color}</Text>
                <View style={styles.buttonRow}>
                  {/* <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" /> */}
                  {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
                  <Pressable
                    style={[styles.button, styles.buttonDelete]}
                    onPress={() => deleteUser(item.id)}   >
                    <Text style={styles.textStyle}>Delete</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonOpen]}
                    onPress={() => openModal(item)}>
                    <Text style={styles.textStyle}>Update</Text>
                  </Pressable>
                </View>
              </View>
            ))
          ) : (
            <Text style={styles.noDataText}>No data available</Text>
          )}


          <View style={styles.centeredView}>
            <Modal
              animationType="slide"
              transparent={true}
              visible={modalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setModalVisible(!modalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Name"
                    value={name}
                    onChangeText={setName}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Color"
                    value={color}
                    onChangeText={setColor}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setModalVisible(!modalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>
          </View>
        </ScrollView>
      </View>
    );
  };

  const styles = StyleSheet.create({
    // home page style
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#f0f0f0',
    },
    itemContainer: {
      backgroundColor: '#fff',
      borderRadius: 8,
      padding: 16,
      marginBottom: 12,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 2,
    },
    itemText: {
      fontSize: 18,
      color: '#333',
      marginBottom: 4,
    },
    noDataText: {
      fontSize: 18,
      color: '#888',
      textAlign: 'center',
      marginTop: 20,
    },
    input: {
      height: 40,
      borderColor: '#ccc',
      borderBottomWidth: 1,
      marginBottom: 15,
      paddingHorizontal: 10,
      width: '100%',
    },
    buttonRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 10,
    },

    // model style
    centeredView: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      marginTop: 22,
    },

    modalView: {
      margin: 20,
      backgroundColor: 'white',
      borderRadius: 20,
      padding: 35,
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 4,
      elevation: 5,
      width: '90%',
    },

    modalText: {
      marginBottom: 15,
      textAlign: 'center',
    },

    button: {
      borderRadius: 20,
      padding: 10,
      elevation: 2,
    },
    buttonOpen: {
      backgroundColor: '#4CAF50',
    },
    buttonClose: {
      backgroundColor: '#2196F3',
    },
    buttonSave: {
      marginBottom: 15,
      backgroundColor: '#4CAF50',
    },
    buttonDelete: {
      backgroundColor: '#ff5c5c',
    },
    textStyle: {
      color: 'white',
      fontWeight: 'bold',
      textAlign: 'center',
    },


  });

  export default App;
}
// Start hare
{

  import React, { useEffect, useState } from 'react';
  import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

  const App = () => {
    const [data, setData] = useState([]);
    const [modalVisible, setModalVisible] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [name, setName] = useState('');
    const [color, setColor] = useState('');
    const [searchText, setSearchText] = useState('');

    const getAPIData = async () => {
      const url = "https://jsonplaceholder.typicode.com/users";
      console.warn(url);
      let result = await fetch(url);
      console.warn(result);
      result = await result.json();
      setData(result);
    };


    useEffect(() => {
      getAPIData();
    }, []);

    const deleteUser = async (id) => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${id}`, {
        method: "DELETE"
      });
      result = await result.json();
      if (result) {
        console.warn("User deleted");
        getAPIData();
      }
    }

    const updateUser = async () => {
      if (!selectedUser) return;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${selectedUser.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, color })
      });
      result = await result.json();
      if (result) {
        console.warn("User updated");
        setModalVisible(false);
        getAPIData();
      }
    }

    // const searchUser = async (text) => {
    //   setSearchText(text);
    //   const url = `http://10.0.2.2:3000/users?q=${text}`;
    //   let result = await fetch(url);
    //   result = await result.json();
    //   console.warn("Search result:", result); // Log the result for debugging
    //   setData(result);
    // }

    const searchUser = async (text) => {
      setSearchText(text);
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      // Filter data based on search text
      const filteredData = result.filter(user =>
        user.name.toLowerCase().includes(text.toLowerCase()) ||
        user.color.toLowerCase().includes(text.toLowerCase())
      );
      // Set filtered data
      setData(filteredData);
    }


    const openModal = (user) => {
      setSelectedUser(user);
      setName(user.name);
      setColor(user.color);
      setModalVisible(true);
    }

    return (
      <View style={styles.container}>
        <View>
          <TextInput
            style={styles.input}
            placeholder="Search"
            value={searchText}
            onChangeText={(text) => searchUser(text)}
          />
        </View>

        <ScrollView>
          {data.length ? (
            data.map((item) => (
              <View key={item.id} style={styles.itemContainer}>
                <Text style={styles.itemText}>IDs: {item.id}</Text>
                <Text style={styles.itemText}>Name: {item.name}</Text>
                <Text style={styles.itemText}>Color: {item.color}</Text>
                <View style={styles.buttonRow}>
                  {/* <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" /> */}
                  {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
                  <Pressable
                    style={[styles.button, styles.buttonDelete]}
                    onPress={() => deleteUser(item.id)}   >
                    <Text style={styles.textStyle}>Delete</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonOpen]}
                    onPress={() => openModal(item)}>
                    <Text style={styles.textStyle}>Update</Text>
                  </Pressable>
                </View>
              </View>
            ))
          ) : (
            <Text style={styles.noDataText}>No data available</Text>
          )}


          <View style={styles.centeredView}>
            <Modal
              animationType="slide"
              transparent={true}
              visible={modalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setModalVisible(!modalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Name"
                    value={name}
                    onChangeText={setName}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Color"
                    value={color}
                    onChangeText={setColor}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setModalVisible(!modalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>
          </View>
        </ScrollView>
      </View>
    );
  };

  const styles = StyleSheet.create({
    // home page style
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#f0f0f0',
    },
    itemContainer: {
      backgroundColor: '#fff',
      borderRadius: 8,
      padding: 16,
      marginBottom: 12,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 2,
    },
    itemText: {
      fontSize: 18,
      color: '#333',
      marginBottom: 4,
    },
    noDataText: {
      fontSize: 18,
      color: '#888',
      textAlign: 'center',
      marginTop: 20,
    },
    input: {
      height: 40,
      borderColor: '#ccc',
      borderBottomWidth: 1,
      marginBottom: 15,
      paddingHorizontal: 10,
      width: '100%',
    },
    buttonRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 10,
    },

    // model style
    centeredView: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      marginTop: 22,
    },

    modalView: {
      margin: 20,
      backgroundColor: 'white',
      borderRadius: 20,
      padding: 35,
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 4,
      elevation: 5,
      width: '90%',
    },

    modalText: {
      marginBottom: 15,
      textAlign: 'center',
    },

    button: {
      borderRadius: 20,
      padding: 10,
      elevation: 2,
    },
    buttonOpen: {
      backgroundColor: '#4CAF50',
    },
    buttonClose: {
      backgroundColor: '#2196F3',
    },
    buttonSave: {
      marginBottom: 15,
      backgroundColor: '#4CAF50',
    },
    buttonDelete: {
      backgroundColor: '#ff5c5c',
    },
    textStyle: {
      color: 'white',
      fontWeight: 'bold',
      textAlign: 'center',
    },


  });

  export default App;
}
//* latest drawer screen 
//* latest drawer screen 
{

  import React, { useEffect, useState } from 'react';
  import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal, Image, TouchableOpacity } from 'react-native';
  import { createDrawerNavigator } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';
  import LinearGradient from 'react-native-linear-gradient';


  function HomeScreen({ navigation }) {
    const [data, setData] = useState([]);
    const [modalVisible, setModalVisible] = useState(false);
    const [createModalVisible, setCreateModalVisible] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [name, setName] = useState('');
    const [color, setColor] = useState('');
    const [searchText, setSearchText] = useState('');


    //Create user
    const [usermame, setUsername] = useState("");
    const [usercolor, setUsercolor] = useState("");



    const getAPIData = async () => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      console.warn(result);
      setData(result);
    }

    useEffect(() => {
      getAPIData();
    }, []);

    const deleteUser = async (id) => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${id}`, {
        method: "DELETE"
      });
      result = await result.json();
      if (result) {
        console.warn("User deleted");
        getAPIData();
      }
    }

    const updateUser = async () => {
      if (!selectedUser) return;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${selectedUser.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, color })
      });
      result = await result.json();
      if (result) {
        console.warn("User updated");
        setModalVisible(false);
        getAPIData();
      }
    }

    const createUser = async () => {
      const usernameValue = usermame;
      const usercolorValue = usercolor;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: usernameValue,
          color: usercolorValue
        })
      });

      result = await result.json();

      if (result) {
        // Optionally, reset the form or perform any other actions
        // Clear name input
        setUsername('');
        // Clear color input
        setUsercolor('');
        // Refresh the user list
        setCreateModalVisible(false);
        getAPIData();
        console.warn("User created:", usernameValue);
      } else {
        console.warn("Failed to create user");
      }
    }

    const searchUser = async (text) => {
      setSearchText(text);
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      // Filter data based on search text
      const filteredData = result.filter(user =>
        user.name.toLowerCase().includes(text.toLowerCase()) ||
        user.color.toLowerCase().includes(text.toLowerCase())
      );
      // Set filtered data
      setData(filteredData);
    }


    const openModal = (user) => {
      setSelectedUser(user);
      setName(user.name);
      setColor(user.color);
      setModalVisible(true);
    }
    const openCreateModal = () => {
      setCreateModalVisible(true);
      // setSelectedUser(user);
      // setName(user.name);
      // setColor(user.color);
    }

    const imageMap = {
      'FB_IMG_1545560289018.jpg': require('./assets/images/FB_IMG_1545560289018.jpg'),
      // Add more mappings as needed
    };

    const defaultImage = require('./assets/images/default.jpg');

    return (
      <View style={styles.container}>
        <View>
          <TextInput
            style={styles.input}
            placeholder="Search"
            value={searchText}
            onChangeText={(text) => searchUser(text)}
          />
        </View>
        <ScrollView>
          {data.length ? (
            data.map((item) => {
              const imageSource = imageMap[item.image] || defaultImage;
              return (
                <View key={item.id} style={styles.itemContainer}>
                  <Text style={styles.itemText}>ID: {item.id}</Text>
                  <Text style={styles.itemText}>Name: {item.name}</Text>
                  <Text style={styles.itemText}>Color: {item.color}</Text>
                  <Image
                    source={imageSource}
                    style={[styles.image, styles.imagepostion]}
                  />
                  <View style={styles.buttonRow}>
                    <Pressable
                      style={[styles.button, styles.buttonDelete]}
                      onPress={() => deleteUser(item.id)}>
                      <Text style={styles.textStyle}>Delete</Text>
                    </Pressable>
                    <Pressable
                      style={[styles.button, styles.buttonOpen]}
                      onPress={() => openModal(item)}>
                      <Text style={styles.textStyle}>Update</Text>
                    </Pressable>
                  </View>
                </View>
              );
            })
          ) : (
            <Text style={styles.noDataText}>No data available</Text>
          )}


          <Pressable
            style={[styles.button, styles.buttonClose]} onPress={() => openCreateModal()}>
            <Text style={styles.textStyle}>Create Users</Text>
          </Pressable>


          <View style={styles.centeredView}>
            {/* model box for update  */}
            <Modal
              animationType="slide"
              transparent={true}
              visible={modalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setModalVisible(!modalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Name"
                    value={name}
                    onChangeText={setName}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Color"
                    value={color}
                    onChangeText={setColor}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setModalVisible(!modalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>

            {/* Create model box for user create  */}
            <Modal
              animationType="slide"
              transparent={true}
              visible={createModalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setCreateModalVisible(!createModalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Enter Name"
                    value={usermame}
                    onChangeText={(text) => setUsername(text)}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Enter Last Name"
                    value={usercolor}
                    onChangeText={(text) => setUsercolor(text)}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={() => createUser()}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setCreateModalVisible(!createModalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>
          </View>
        </ScrollView>
      </View>
    );
  }


  function NotificationsScreen({ navigation }) {
    return (
      <LinearGradient
        colors={['purple', 'white']}
        style={styles.container1}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 1 }}>
        {/* <View style={{flex: 1, alignItems: 'center', justifyContent: 'center'}}> */}
        {/* <Button onPress={() => navigation.goBack()} title="Go back home" /> */}
        {/* </View> */}
        {/* <Text>Login Screen</Text> */}
        <TouchableOpacity onPress={() => { }}>
          <LinearGradient
            start={{ x: 0, y: 0 }}
            end={{ x: 1, y: 1 }}
            colors={['#5851DB', '#C13584', '#E1306C', '#FD1D1D', '#F77737']}
            style={styles.instagramButton}>
            {/* <Text style={{color: 'white'}}>Sign In With Instagram</Text> */}
            <Text style={{ color: 'white' }}>Login</Text>
          </LinearGradient>
        </TouchableOpacity>
        <LinearGradient
          start={{ x: 0, y: 0 }}
          end={{ x: 1, y: 1 }}
          colors={['red', 'yellow', 'green']}
          style={{
            alignItems: 'center',
            justifyContent: 'center',
            borderRadius: 10,
          }}>
          <TouchableOpacity onPress={() => { }} style={styles.signUpButton}>
            <Text>Sign Up</Text>
          </TouchableOpacity>
        </LinearGradient>
      </LinearGradient>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator initialRouteName="Home">
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="Login" component={NotificationsScreen} />
          <Drawer.Screen name="Shahid" component={NotificationsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    container1: {
      flex: 1,
      alignItems: 'center',
      justifyContent: 'center',
    },

    instagramButton: {
      paddingHorizontal: 40,
      paddingVertical: 10,
      borderRadius: 10,
      margin: 20,
    },
    signUpButton: {
      margin: 1,
      width: 200,
      borderRadius: 10,
      paddingVertical: 10,
      alignItems: 'center',
      justifyContent: 'center',
      backgroundColor: 'white',
    },

    // after geta data design


    // home page style
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#f0f0f0',
    },
    itemContainer: {
      backgroundColor: '#fff',
      borderRadius: 8,
      padding: 16,
      marginBottom: 12,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 2,
      // position: 'relative',
    },
    itemText: {
      fontSize: 18,
      color: '#333',
      marginBottom: 4,
    },
    noDataText: {
      fontSize: 18,
      color: '#888',
      textAlign: 'center',
      marginTop: 20,
    },
    input: {
      height: 40,
      borderColor: '#ccc',
      borderBottomWidth: 1,
      marginBottom: 15,
      paddingHorizontal: 10,
      width: '100%',
    },
    buttonRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 10,
    },

    // model style
    centeredView: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      marginTop: 22,
    },

    modalView: {
      margin: 20,
      backgroundColor: 'white',
      borderRadius: 20,
      padding: 35,
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 4,
      elevation: 5,
      width: '90%',
    },

    modalText: {
      marginBottom: 15,
      textAlign: 'center',
    },

    button: {
      borderRadius: 20,
      padding: 10,
      elevation: 2,
    },
    buttonOpen: {
      backgroundColor: '#4CAF50',
    },
    buttonClose: {
      backgroundColor: '#2196F3',
    },
    buttonSave: {
      marginBottom: 15,
      backgroundColor: '#4CAF50',
    },
    buttonDelete: {
      backgroundColor: '#ff5c5c',
    },
    textStyle: {
      color: 'white',
      fontWeight: 'bold',
      textAlign: 'center',
    },
    // image 
    image: {
      width: 50,
      height: 50,
      borderRadius: 100, // Optional: Add border radius for rounded corners
    },
    imagecontainer: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },

    imagepostion: {
      //   position: 'relative',
      position: 'absolute',
      bottom: 95,
      left: 310,
    }


    // gradient: {
    //   flex: 5,
    // },
  });



  export default App;
}
// Start hare
{
  import React, { useEffect, useState } from 'react';
  import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal, Image, TouchableOpacity } from 'react-native';
  import { createDrawerNavigator } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';
  import LinearGradient from 'react-native-linear-gradient';


  function HomeScreen({ navigation }) {
    const [data, setData] = useState([]);
    const [modalVisible, setModalVisible] = useState(false);
    const [createModalVisible, setCreateModalVisible] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [name, setName] = useState('');
    const [color, setColor] = useState('');
    const [searchText, setSearchText] = useState('');


    //Create user
    const [usermame, setUsername] = useState("");
    const [usercolor, setUsercolor] = useState("");



    const getAPIData = async () => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      console.warn(result);
      setData(result);
    }

    useEffect(() => {
      getAPIData();
    }, []);

    const deleteUser = async (id) => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${id}`, {
        method: "DELETE"
      });
      result = await result.json();
      if (result) {
        console.warn("User deleted");
        getAPIData();
      }
    }

    const updateUser = async () => {
      if (!selectedUser) return;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${selectedUser.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, color })
      });
      result = await result.json();
      if (result) {
        console.warn("User updated");
        setModalVisible(false);
        getAPIData();
      }
    }

    const createUser = async () => {
      const usernameValue = usermame;
      const usercolorValue = usercolor;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: usernameValue,
          color: usercolorValue
        })
      });

      result = await result.json();

      if (result) {
        // Optionally, reset the form or perform any other actions
        // Clear name input
        setUsername('');
        // Clear color input
        setUsercolor('');
        // Refresh the user list
        setCreateModalVisible(false);
        getAPIData();
        console.warn("User created:", usernameValue);
      } else {
        console.warn("Failed to create user");
      }
    }

    const searchUser = async (text) => {
      setSearchText(text);
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      // Filter data based on search text
      const filteredData = result.filter(user =>
        user.name.toLowerCase().includes(text.toLowerCase()) ||
        user.color.toLowerCase().includes(text.toLowerCase())
      );
      // Set filtered data
      setData(filteredData);
    }


    const openModal = (user) => {
      setSelectedUser(user);
      setName(user.name);
      setColor(user.color);
      setModalVisible(true);
    }
    const openCreateModal = () => {
      setCreateModalVisible(true);
      // setSelectedUser(user);
      // setName(user.name);
      // setColor(user.color);
    }

    const imageMap = {
      'FB_IMG_1545560289018.jpg': require('./assets/images/FB_IMG_1545560289018.jpg'),
      // Add more mappings as needed
    };

    const defaultImage = require('./assets/images/default.jpg');

    return (
      <View style={styles.container}>
        <View>
          <TextInput
            style={styles.input}
            placeholder="Search"
            value={searchText}
            onChangeText={(text) => searchUser(text)}
          />
        </View>
        <ScrollView>
          {data.length ? (
            data.map((item) => {
              const imageSource = imageMap[item.image] || defaultImage;
              return (
                <View key={item.id} style={styles.itemContainer}>
                  <Text style={styles.itemText}>ID: {item.id}</Text>
                  <Text style={styles.itemText}>Name: {item.name}</Text>
                  <Text style={styles.itemText}>Color: {item.color}</Text>
                  <Image
                    source={imageSource}
                    style={[styles.image, styles.imagepostion]}
                  />
                  <View style={styles.buttonRow}>
                    <Pressable
                      style={[styles.button, styles.buttonDelete]}
                      onPress={() => deleteUser(item.id)}>
                      <Text style={styles.textStyle}>Delete</Text>
                    </Pressable>
                    <Pressable
                      style={[styles.button, styles.buttonOpen]}
                      onPress={() => openModal(item)}>
                      <Text style={styles.textStyle}>Update</Text>
                    </Pressable>
                  </View>
                </View>
              );
            })
          ) : (
            <Text style={styles.noDataText}>No data available</Text>
          )}


          <Pressable
            style={[styles.button, styles.buttonClose]} onPress={() => openCreateModal()}>
            <Text style={styles.textStyle}>Create Users</Text>
          </Pressable>


          <View style={styles.centeredView}>
            {/* model box for update  */}
            <Modal
              animationType="slide"
              transparent={true}
              visible={modalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setModalVisible(!modalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Name"
                    value={name}
                    onChangeText={setName}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Color"
                    value={color}
                    onChangeText={setColor}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setModalVisible(!modalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>

            {/* Create model box for user create  */}
            <Modal
              animationType="slide"
              transparent={true}
              visible={createModalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setCreateModalVisible(!createModalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Enter Name"
                    value={usermame}
                    onChangeText={(text) => setUsername(text)}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Enter Last Name"
                    value={usercolor}
                    onChangeText={(text) => setUsercolor(text)}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={() => createUser()}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setCreateModalVisible(!createModalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>
          </View>
        </ScrollView>
      </View>
    );
  }


  function NotificationsScreen({ navigation }) {
    return (
      <LinearGradient
        colors={['purple', 'white']}
        style={styles.container1}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 1 }}>
        {/* <View style={{flex: 1, alignItems: 'center', justifyContent: 'center'}}> */}
        {/* <Button onPress={() => navigation.goBack()} title="Go back home" /> */}
        {/* </View> */}
        {/* <Text>Login Screen</Text> */}
        <TouchableOpacity onPress={() => { }}>
          <LinearGradient
            start={{ x: 0, y: 0 }}
            end={{ x: 1, y: 1 }}
            colors={['#5851DB', '#C13584', '#E1306C', '#FD1D1D', '#F77737']}
            style={styles.instagramButton}>
            {/* <Text style={{color: 'white'}}>Sign In With Instagram</Text> */}
            <Text style={{ color: 'white' }}>Login</Text>
          </LinearGradient>
        </TouchableOpacity>
        <LinearGradient
          start={{ x: 0, y: 0 }}
          end={{ x: 1, y: 1 }}
          colors={['red', 'yellow', 'green']}
          style={{
            alignItems: 'center',
            justifyContent: 'center',
            borderRadius: 10,
          }}>
          <TouchableOpacity onPress={() => { }} style={styles.signUpButton}>
            <Text>Sign Up</Text>
          </TouchableOpacity>
        </LinearGradient>
      </LinearGradient>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator initialRouteName="Home">
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="Login" component={NotificationsScreen} />
          <Drawer.Screen name="Shahid" component={NotificationsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    container1: {
      flex: 1,
      alignItems: 'center',
      justifyContent: 'center',
    },

    instagramButton: {
      paddingHorizontal: 40,
      paddingVertical: 10,
      borderRadius: 10,
      margin: 20,
    },
    signUpButton: {
      margin: 1,
      width: 200,
      borderRadius: 10,
      paddingVertical: 10,
      alignItems: 'center',
      justifyContent: 'center',
      backgroundColor: 'white',
    },

    // after geta data design


    // home page style
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#f0f0f0',
    },
    itemContainer: {
      backgroundColor: '#fff',
      borderRadius: 8,
      padding: 16,
      marginBottom: 12,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 2,
      // position: 'relative',
    },
    itemText: {
      fontSize: 18,
      color: '#333',
      marginBottom: 4,
    },
    noDataText: {
      fontSize: 18,
      color: '#888',
      textAlign: 'center',
      marginTop: 20,
    },
    input: {
      height: 40,
      borderColor: '#ccc',
      borderBottomWidth: 1,
      marginBottom: 15,
      paddingHorizontal: 10,
      width: '100%',
    },
    buttonRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 10,
    },

    // model style
    centeredView: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      marginTop: 22,
    },

    modalView: {
      margin: 20,
      backgroundColor: 'white',
      borderRadius: 20,
      padding: 35,
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 4,
      elevation: 5,
      width: '90%',
    },

    modalText: {
      marginBottom: 15,
      textAlign: 'center',
    },

    button: {
      borderRadius: 20,
      padding: 10,
      elevation: 2,
    },
    buttonOpen: {
      backgroundColor: '#4CAF50',
    },
    buttonClose: {
      backgroundColor: '#2196F3',
    },
    buttonSave: {
      marginBottom: 15,
      backgroundColor: '#4CAF50',
    },
    buttonDelete: {
      backgroundColor: '#ff5c5c',
    },
    textStyle: {
      color: 'white',
      fontWeight: 'bold',
      textAlign: 'center',
    },
    // image 
    image: {
      width: 50,
      height: 50,
      borderRadius: 100, // Optional: Add border radius for rounded corners
    },
    imagecontainer: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },

    imagepostion: {
      //   position: 'relative',
      position: 'absolute',
      bottom: 95,
      left: 310,
    }


    // gradient: {
    //   flex: 5,
    // },
  });



  export default App;
}
// Start hare
{

}
//* it is allready shold be in file 
// Start hare  it is allready shold be in file 
{

  import React, { useEffect, useState } from 'react';
  import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

  const App = () => {
    const [data, setData] = useState([]);
    const [modalVisible, setModalVisible] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [name, setName] = useState('');
    const [color, setColor] = useState('');
    const [searchText, setSearchText] = useState('');

    const getAPIData = async () => {
      const url = "https://jsonplaceholder.typicode.com/users";
      console.warn(url);
      let result = await fetch(url);
      console.warn(result);
      result = await result.json();
      setData(result);
    };


    useEffect(() => {
      getAPIData();
    }, []);

    const deleteUser = async (id) => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${id}`, {
        method: "DELETE"
      });
      result = await result.json();
      if (result) {
        console.warn("User deleted");
        getAPIData();
      }
    }

    const updateUser = async () => {
      if (!selectedUser) return;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${selectedUser.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, color })
      });
      result = await result.json();
      if (result) {
        console.warn("User updated");
        setModalVisible(false);
        getAPIData();
      }
    }

    // const searchUser = async (text) => {
    //   setSearchText(text);
    //   const url = `http://10.0.2.2:3000/users?q=${text}`;
    //   let result = await fetch(url);
    //   result = await result.json();
    //   console.warn("Search result:", result); // Log the result for debugging
    //   setData(result);
    // }

    const searchUser = async (text) => {
      setSearchText(text);
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      // Filter data based on search text
      const filteredData = result.filter(user =>
        user.name.toLowerCase().includes(text.toLowerCase()) ||
        user.color.toLowerCase().includes(text.toLowerCase())
      );
      // Set filtered data
      setData(filteredData);
    }


    const openModal = (user) => {
      setSelectedUser(user);
      setName(user.name);
      setColor(user.color);
      setModalVisible(true);
    }

    return (
      <View style={styles.container}>
        <View>
          <TextInput
            style={styles.input}
            placeholder="Search"
            value={searchText}
            onChangeText={(text) => searchUser(text)}
          />
        </View>

        <ScrollView>
          {data.length ? (
            data.map((item) => (
              <View key={item.id} style={styles.itemContainer}>
                <Text style={styles.itemText}>ID: {item.id}</Text>
                <Text style={styles.itemText}>Name: {item.name}</Text>
                <Text style={styles.itemText}>Color: {item.color}</Text>
                <View style={styles.buttonRow}>
                  {/* <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" /> */}
                  {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
                  <Pressable
                    style={[styles.button, styles.buttonDelete]}
                    onPress={() => deleteUser(item.id)}   >
                    <Text style={styles.textStyle}>Delete</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonOpen]}
                    onPress={() => openModal(item)}>
                    <Text style={styles.textStyle}>Update</Text>
                  </Pressable>
                </View>
              </View>
            ))
          ) : (
            <Text style={styles.noDataText}>No data available</Text>
          )}


          <View style={styles.centeredView}>
            <Modal
              animationType="slide"
              transparent={true}
              visible={modalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setModalVisible(!modalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Name"
                    value={name}
                    onChangeText={setName}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Color"
                    value={color}
                    onChangeText={setColor}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setModalVisible(!modalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>
          </View>
        </ScrollView>
      </View>
    );
  };

  const styles = StyleSheet.create({
    // home page style
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#f0f0f0',
    },
    itemContainer: {
      backgroundColor: '#fff',
      borderRadius: 8,
      padding: 16,
      marginBottom: 12,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 2,
    },
    itemText: {
      fontSize: 18,
      color: '#333',
      marginBottom: 4,
    },
    noDataText: {
      fontSize: 18,
      color: '#888',
      textAlign: 'center',
      marginTop: 20,
    },
    input: {
      height: 40,
      borderColor: '#ccc',
      borderBottomWidth: 1,
      marginBottom: 15,
      paddingHorizontal: 10,
      width: '100%',
    },
    buttonRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 10,
    },

    // model style
    centeredView: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      marginTop: 22,
    },

    modalView: {
      margin: 20,
      backgroundColor: 'white',
      borderRadius: 20,
      padding: 35,
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 4,
      elevation: 5,
      width: '90%',
    },

    modalText: {
      marginBottom: 15,
      textAlign: 'center',
    },

    button: {
      borderRadius: 20,
      padding: 10,
      elevation: 2,
    },
    buttonOpen: {
      backgroundColor: '#4CAF50',
    },
    buttonClose: {
      backgroundColor: '#2196F3',
    },
    buttonSave: {
      marginBottom: 15,
      backgroundColor: '#4CAF50',
    },
    buttonDelete: {
      backgroundColor: '#ff5c5c',
    },
    textStyle: {
      color: 'white',
      fontWeight: 'bold',
      textAlign: 'center',
    },


  });

  export default App;
}
// Start hare
{

}

//* api fetch template / regarding api 
// Start hare
{

  import React, { useState, useEffect } from 'react';

  const MyComponent = () => {
    const [data, setData] = useState([]);
    const [error, setError] = useState(null);

    const getAPIData = async () => {
      const url = "https://jsonplaceholder.typicode.com/posts";

      try {
        console.warn('Fetching data from:', url);
        let response = await fetch(url);
        console.warn('Response status:', response.status);

        if (!response.ok) {
          throw new Error(`Network response was not ok. Status: ${response.status}`);
        }

        let result = await response.json();
        console.warn('Fetched data:', result);

        setData(result);
      } catch (error) {
        console.error('Error fetching data:', error);
        setError(error.message);
      }
    }

    useEffect(() => {
      getAPIData();
    }, []);

    return (
      <div>
        {error && <p>Error: {error}</p>}
        {data.length > 0 ? (
          <ul>
            {data.map(item => (
              <li key={item.id}>{item.title}</li>
            ))}
          </ul>
        ) : (
          <p>Loading...</p>
        )}
      </div>
    );
  }

  export default MyComponent;
}

// Start hare
{
  import React, { useState, useEffect } from 'react';
  import { View, Text, FlatList, ActivityIndicator, StyleSheet } from 'react-native';

  const MyComponent = () => {
    const [data, setData] = useState([]);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);

    const getAPIData = async () => {
      const url = "http://10.0.2.2:3000/users";

      try {
        let response = await fetch(url);
        console.warn('Response status:', response.status);

        if (!response.ok) {
          throw new Error(`Network response was not ok. Status: ${response.status}`);
        }

        let result = await response.json();
        console.warn('Fetched data:', result);

        setData(result);
        setLoading(false);
      } catch (error) {
        console.error('Error fetching data:', error);
        setError(error.message);
        setLoading(false);
      }
    }

    useEffect(() => {
      getAPIData();
    }, []);

    if (loading) {
      return <ActivityIndicator size="large" color="#0000ff" />;
    }

    return (
      <View style={styles.container}>
        {error && <Text style={styles.error}>Error: {error}</Text>}
        {data.length > 0 ? (
          <FlatList
            data={data}
            keyExtractor={(item) => item.id.toString()}
            renderItem={({ item }) => (
              <View style={styles.item}>
                <Text>{item.name}</Text>
              </View>
            )}
          />
        ) : (
          <Text>No data available</Text>
        )}
      </View>
    );
  }

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      padding: 16,
    },
    error: {
      color: 'red',
      marginBottom: 10,
    },
    item: {
      padding: 10,
      borderBottomWidth: 1,
      borderBottomColor: '#ccc',
    },
  });

  export default MyComponent;

}
// Start hare
//* display json data on page 
// Start hare
return (
  <View style={styles.container}>
    <Text>Home Screen 3</Text>
    {/* Display fetched data */}
    {data.length > 0 && (
      <Text>Data fetched successfully: {JSON.stringify(data[0])}</Text>
    )}
  </View>
);

// Start hare
//* latest drawer screen with image 
// Start hare

{

  import React, { useEffect, useState } from 'react';
  import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal, Image, TouchableOpacity } from 'react-native';
  import { createDrawerNavigator } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';
  import LinearGradient from 'react-native-linear-gradient';


  function HomeScreen({ navigation }) {
    const [data, setData] = useState([]);
    const [modalVisible, setModalVisible] = useState(false);
    const [createModalVisible, setCreateModalVisible] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [name, setName] = useState('');
    const [color, setColor] = useState('');
    const [searchText, setSearchText] = useState('');


    //Create user
    const [usermame, setUsername] = useState("");
    const [usercolor, setUsercolor] = useState("");



    const getAPIData = async () => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      console.warn(result);
      setData(result);
    }

    useEffect(() => {
      getAPIData();
    }, []);

    const deleteUser = async (id) => {
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${id}`, {
        method: "DELETE"
      });
      result = await result.json();
      if (result) {
        console.warn("User deleted");
        getAPIData();
      }
    }

    const updateUser = async () => {
      if (!selectedUser) return;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(`${url}/${selectedUser.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, color })
      });
      result = await result.json();
      if (result) {
        console.warn("User updated");
        setModalVisible(false);
        getAPIData();
      }
    }

    const createUser = async () => {
      const usernameValue = usermame;
      const usercolorValue = usercolor;

      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: usernameValue,
          color: usercolorValue
        })
      });

      result = await result.json();

      if (result) {
        // Optionally, reset the form or perform any other actions
        // Clear name input
        setUsername('');
        // Clear color input
        setUsercolor('');
        // Refresh the user list
        setCreateModalVisible(false);
        getAPIData();
        console.warn("User created:", usernameValue);
      } else {
        console.warn("Failed to create user");
      }
    }

    const searchUser = async (text) => {
      setSearchText(text);
      const url = "http://10.0.2.2:3000/users";
      let result = await fetch(url);
      result = await result.json();
      // Filter data based on search text
      const filteredData = result.filter(user =>
        user.name.toLowerCase().includes(text.toLowerCase()) ||
        user.color.toLowerCase().includes(text.toLowerCase())
      );
      // Set filtered data
      setData(filteredData);
    }


    const openModal = (user) => {
      setSelectedUser(user);
      setName(user.name);
      setColor(user.color);
      setModalVisible(true);
    }
    const openCreateModal = () => {
      setCreateModalVisible(true);
      // setSelectedUser(user);
      // setName(user.name);
      // setColor(user.color);
    }

    const imageMap = {
      'FB_IMG_1545560289018.jpg': require('./assets/images/FB_IMG_1545560289018.jpg'),
      // Add more mappings as needed
    };

    const defaultImage = require('./assets/images/default.jpg');

    return (
      <View style={styles.container}>
        <View>
          <TextInput
            style={styles.input}
            placeholder="Search"
            value={searchText}
            onChangeText={(text) => searchUser(text)}
          />
        </View>
        <ScrollView>
          {data.length ? (
            data.map((item) => {
              const imageSource = imageMap[item.image] || defaultImage;
              return (
                <View key={item.id} style={styles.itemContainer}>
                  <Text style={styles.itemText}>ID: {item.id}</Text>
                  <Text style={styles.itemText}>Name: {item.name}</Text>
                  <Text style={styles.itemText}>Color: {item.color}</Text>
                  <Image
                    source={imageSource}
                    style={[styles.image, styles.imagepostion]}
                  />
                  <View style={styles.buttonRow}>
                    <Pressable
                      style={[styles.button, styles.buttonDelete]}
                      onPress={() => deleteUser(item.id)}>
                      <Text style={styles.textStyle}>Delete</Text>
                    </Pressable>
                    <Pressable
                      style={[styles.button, styles.buttonOpen]}
                      onPress={() => openModal(item)}>
                      <Text style={styles.textStyle}>Update</Text>
                    </Pressable>
                  </View>
                </View>
              );
            })
          ) : (
            <Text style={styles.noDataText}>No data available</Text>
          )}


          <Pressable
            style={[styles.button, styles.buttonClose]} onPress={() => openCreateModal()}>
            <Text style={styles.textStyle}>Create Users</Text>
          </Pressable>


          <View style={styles.centeredView}>
            {/* model box for update  */}
            <Modal
              animationType="slide"
              transparent={true}
              visible={modalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setModalVisible(!modalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Name"
                    value={name}
                    onChangeText={setName}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Color"
                    value={color}
                    onChangeText={setColor}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setModalVisible(!modalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>

            {/* Create model box for user create  */}
            <Modal
              animationType="slide"
              transparent={true}
              visible={createModalVisible}
              onRequestClose={() => {
                // Alert.alert('Modal has been closed.');
                setCreateModalVisible(!createModalVisible);
              }}>
              <View style={styles.centeredView}>
                <View style={styles.modalView}>
                  <Text style={styles.modalText}>Update Details</Text>

                  <TextInput
                    style={styles.input}
                    placeholder="Enter Name"
                    value={usermame}
                    onChangeText={(text) => setUsername(text)}
                  />
                  <TextInput
                    style={styles.input}
                    placeholder="Enter Last Name"
                    value={usercolor}
                    onChangeText={(text) => setUsercolor(text)}
                  />

                  <Pressable
                    style={[styles.button, styles.buttonSave]} onPress={() => createUser()}>
                    <Text style={styles.textStyle}>Save</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonClose]}
                    onPress={() => setCreateModalVisible(!createModalVisible)}>
                    <Text style={styles.textStyle}>Hide Modal</Text>
                  </Pressable>
                </View>
              </View>
            </Modal>
          </View>
        </ScrollView>
      </View>
    );
  }

  function NotificationsScreen({ navigation }) {
    return (
      <LinearGradient
        colors={['purple', 'white']}
        style={styles.container1}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 1 }}>
        {/* <View style={{flex: 1, alignItems: 'center', justifyContent: 'center'}}> */}
        <Button onPress={() => navigation.goBack()} title="Go back home" />
        {/* </View> */}
        <Text>Login Screen</Text>
        <TouchableOpacity onPress={() => { }}>
          <LinearGradient
            start={{ x: 0, y: 0 }}
            end={{ x: 1, y: 1 }}
            colors={['#5851DB', '#C13584', '#E1306C', '#FD1D1D', '#F77737']}
            style={styles.instagramButton}>
            {/* <Text style={{color: 'white'}}>Sign In With Instagram</Text> */}
            <Text style={{ color: 'white' }}>Login</Text>
          </LinearGradient>
        </TouchableOpacity>
        <LinearGradient
          start={{ x: 0, y: 0 }}
          end={{ x: 1, y: 1 }}
          colors={['red', 'yellow', 'green']}
          style={{
            alignItems: 'center',
            justifyContent: 'center',
            borderRadius: 10,
          }}>
          <TouchableOpacity onPress={() => { }} style={styles.signUpButton}>
            <Text>Sign Up</Text>
          </TouchableOpacity>
        </LinearGradient>
      </LinearGradient>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator initialRouteName="Home">
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="Notifications" component={NotificationsScreen} />
          <Drawer.Screen name="shahid" component={NotificationsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    container1: {
      flex: 1,
      alignItems: 'center',
      justifyContent: 'center',
    },

    instagramButton: {
      paddingHorizontal: 40,
      paddingVertical: 10,
      borderRadius: 10,
      margin: 20,
    },
    signUpButton: {
      margin: 1,
      width: 200,
      borderRadius: 10,
      paddingVertical: 10,
      alignItems: 'center',
      justifyContent: 'center',
      backgroundColor: 'white',
    },

    // after geta data design


    // home page style
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#f0f0f0',
    },
    itemContainer: {
      backgroundColor: '#fff',
      borderRadius: 8,
      padding: 16,
      marginBottom: 12,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 2 },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 2,
      // position: 'relative',
    },
    itemText: {
      fontSize: 18,
      color: '#333',
      marginBottom: 4,
    },
    noDataText: {
      fontSize: 18,
      color: '#888',
      textAlign: 'center',
      marginTop: 20,
    },
    input: {
      height: 40,
      borderColor: '#ccc',
      borderBottomWidth: 1,
      marginBottom: 15,
      paddingHorizontal: 10,
      width: '100%',
    },
    buttonRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 10,
    },

    // model style
    centeredView: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      marginTop: 22,
    },

    modalView: {
      margin: 20,
      backgroundColor: 'white',
      borderRadius: 20,
      padding: 35,
      alignItems: 'center',
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 4,
      elevation: 5,
      width: '90%',
    },

    modalText: {
      marginBottom: 15,
      textAlign: 'center',
    },

    button: {
      borderRadius: 20,
      padding: 10,
      elevation: 2,
    },
    buttonOpen: {
      backgroundColor: '#4CAF50',
    },
    buttonClose: {
      backgroundColor: '#2196F3',
    },
    buttonSave: {
      marginBottom: 15,
      backgroundColor: '#4CAF50',
    },
    buttonDelete: {
      backgroundColor: '#ff5c5c',
    },
    textStyle: {
      color: 'white',
      fontWeight: 'bold',
      textAlign: 'center',
    },
    // image 
    image: {
      width: 50,
      height: 50,
      borderRadius: 100, // Optional: Add border radius for rounded corners
    },
    imagecontainer: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },

    imagepostion: {
      //   position: 'relative',
      position: 'absolute',
      bottom: 95,
      left: 310,
    }


    // gradient: {
    //   flex: 5,
    // },
  });



  export default App;
}
// Start hare
//* regarding alret box
// Start hare
const confirmDelete = (id) => {
  Alert.alert(
    "Delete User",
    "Are you sure you want to delete this user?",
    [
      { text: "Cancel", style: "cancel" },
      { text: "OK", onPress: () => deleteUser(id) }
    ]
  );
}

// Start hare
//* linear gradient
// Start hare
{
  import * as React from 'react';
  import { Button, View, StyleSheet, Text, TouchableOpacity } from 'react-native';
  import { createDrawerNavigator } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';
  import LinearGradient from 'react-native-linear-gradient';

  // function HomeScreen({ navigation }) {
  //   return (
  //     <LinearGradient
  //       colors={['#ff69b4', '#87ceeb', '#ff6347']} // Pink, Blue, Red
  //       style={styles.gradient}
  //     >
  //       <View style={styles.container}>
  //         <Button
  //           onPress={() => navigation.navigate('Notifications')}
  //           title="Go to notifications"
  //         />
  //       </View>
  //     </LinearGradient>
  //   );
  // }


  // function NotificationsScreen({navigation}) {
  //   return (
  //     <View style={{flex: 1, alignItems: 'center', justifyContent: 'center'}}>
  //       <Button onPress={() => navigation.goBack()} title="Go back home" />
  //     </View>
  //   );
  // }

  function HomeScreen({ navigation }) {
    return (
      <LinearGradient
        colors={['purple', 'white']}
        style={styles.container}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 1 }}>
        <Text>Home Screen</Text>

        {/* <View style={styles.container}> */}
        <Button
          onPress={() => navigation.navigate('Notifications')}
          title="Go to notifications"
        />
        {/* </View> */}
      </LinearGradient>
    );
  }

  function NotificationsScreen({ navigation }) {
    return (
      <LinearGradient
        colors={['purple', 'white']}
        style={styles.container}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 1 }}>
        {/* <View style={{flex: 1, alignItems: 'center', justifyContent: 'center'}}> */}
        <Button onPress={() => navigation.goBack()} title="Go back home" />
        {/* </View> */}
        <Text>Login Screen</Text>
        <TouchableOpacity onPress={() => { }}>
          <LinearGradient
            start={{ x: 0, y: 0 }}
            end={{ x: 1, y: 1 }}
            colors={['#5851DB', '#C13584', '#E1306C', '#FD1D1D', '#F77737']}
            style={styles.instagramButton}>
            {/* <Text style={{color: 'white'}}>Sign In With Instagram</Text> */}
            <Text style={{ color: 'white' }}>Login</Text>
          </LinearGradient>
        </TouchableOpacity>
        <LinearGradient
          start={{ x: 0, y: 0 }}
          end={{ x: 1, y: 1 }}
          colors={['red', 'yellow', 'green']}
          style={{
            alignItems: 'center',
            justifyContent: 'center',
            borderRadius: 10,
          }}>
          <TouchableOpacity onPress={() => { }} style={styles.signUpButton}>
            <Text>Sign Up</Text>
          </TouchableOpacity>
        </LinearGradient>
      </LinearGradient>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator initialRouteName="Home">
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="Notifications" component={NotificationsScreen} />
          <Drawer.Screen name="shahid" component={NotificationsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      alignItems: 'center',
      justifyContent: 'center',
    },

    instagramButton: {
      paddingHorizontal: 40,
      paddingVertical: 10,
      borderRadius: 10,
      margin: 20,
    },
    signUpButton: {
      margin: 1,
      width: 200,
      borderRadius: 10,
      paddingVertical: 10,
      alignItems: 'center',
      justifyContent: 'center',
      backgroundColor: 'white',
    },

    // gradient: {
    //   flex: 5,
    // },
  });

  export default App;
}

// Start hare
//* regarding navigation 
// Start hare
// Start hare
// Start hare


// Start hare for drawer navigation 2

{
  import 'react-native-gesture-handler';
  import React from 'react';
  import { View, Text, Button, StyleSheet, Linking, useWindowDimensions } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createDrawerNavigator, DrawerContentScrollView, DrawerItemList, DrawerItem, useDrawerProgress } from '@react-navigation/drawer';
  import Animated, { useSharedValue, useAnimatedStyle, withSpring } from 'react-native-reanimated';

  // Screens
  const Feed = () => (
    <View style={styles.container}>
      <Text>This is Feed page</Text>
    </View>
  );

  const Article = () => (
    <View style={styles.container}>
      <Text>This is Article page</Text>
    </View>
  );

  const Profile = () => (
    <View style={styles.container}>
      <Text>This is Profile page</Text>
    </View>
  );

  // Custom Drawer Content Component
  function CustomDrawerContent(props) {
    const progress = useDrawerProgress(); // progress is a shared value
    const translateX = useSharedValue(-100); // Initial value for translation

    // Update translateX based on drawer progress
    useAnimatedStyle(() => {
      translateX.value = withSpring(progress.value * -100);
      return {
        transform: [{ translateX: translateX.value }],
      };
    });

    return (
      <Animated.View style={[styles.drawerContainer]}>
        <DrawerContentScrollView {...props}>
          <DrawerItemList {...props} />
          <DrawerItem
            label="Help"
            onPress={() => Linking.openURL('https://mywebsite.com/help')}
          />
        </DrawerContentScrollView>
      </Animated.View>
    );
  }

  // Create Drawer Navigator
  const Drawer = createDrawerNavigator();

  function MyDrawer() {
    const dimensions = useWindowDimensions();
    const isLargeScreen = dimensions.width >= 768;

    return (
      <Drawer.Navigator
        drawerContent={(props) => <CustomDrawerContent {...props} />}
        screenOptions={{
          drawerType: isLargeScreen ? 'permanent' : 'back',
          drawerStyle: isLargeScreen ? null : { width: '100%' },
          overlayColor: 'transparent',
        }}
      >
        <Drawer.Screen
          name="Feed"
          component={Feed}
          options={{ drawerLabel: 'Home' }}
        />
        <Drawer.Screen
          name="Article"
          component={Article}
          options={{ drawerLabel: 'Article' }}
        />
        <Drawer.Screen
          name="Profile"
          component={Profile}
          options={{ drawerLabel: 'Profile' }}
        />
      </Drawer.Navigator>
    );
  }

  const App = () => {
    return (
      <NavigationContainer>
        <MyDrawer />
      </NavigationContainer>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    drawerContainer: {
      flex: 1,
    },
  });

  export default App;
}
// Start hare for drawer navigation 1

{
  import * as React from 'react';
  import { Button, View } from 'react-native';
  import { createDrawerNavigator } from '@react-navigation/drawer';
  import { NavigationContainer } from '@react-navigation/native';

  function HomeScreen({ navigation }) {
    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <Button
          onPress={() => navigation.navigate('Notifications')}
          title="Go to notifications"
        />
      </View>
    );
  }

  function NotificationsScreen({ navigation }) {
    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <Button onPress={() => navigation.goBack()} title="Go back home" />
      </View>
    );
  }

  const Drawer = createDrawerNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Drawer.Navigator initialRouteName="Home">
          <Drawer.Screen name="Home" component={HomeScreen} />
          <Drawer.Screen name="Notifications" component={NotificationsScreen} />
        </Drawer.Navigator>
      </NavigationContainer>
    );
  }

  export default App;
}

// Start hare  for top tab navigation 2
{
  import React from 'react';
  import { View, Text, TouchableOpacity, StyleSheet, Dimensions } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createMaterialTopTabNavigator } from '@react-navigation/material-top-tabs';
  import { Animated } from 'react-native';

  // Screens
  const Feed = () => (
    <View style={styles.container}>
      <Text>This is Feed page</Text>
    </View>
  );

  const Notifications = () => (
    <View style={styles.container}>
      <Text>This is Notifications page</Text>
    </View>
  );

  const Profile = () => (
    <View style={styles.container}>
      <Text>This is Profile page</Text>
    </View>
  );

  // Create Tab Navigator
  const Tab = createMaterialTopTabNavigator();

  // Custom Tab Bar Component
  function MyTabBar({ state, descriptors, navigation, position }) {
    const inputRange = state.routes.map((_, i) => i);

    return (
      <View style={styles.tabBarContainer}>
        {state.routes.map((route, index) => {
          const { options } = descriptors[route.key];
          const label =
            options.tabBarLabel !== undefined
              ? options.tabBarLabel
              : options.title !== undefined
                ? options.title
                : route.name;

          const isFocused = state.index === index;

          const onPress = () => {
            if (!isFocused) {
              navigation.jumpTo(route.name); // Use jumpTo to switch tabs
            }
          };

          const onLongPress = () => {
            navigation.emit({
              type: 'tabLongPress',
              target: route.key,
            });
          };

          const opacity = position.interpolate({
            inputRange,
            outputRange: inputRange.map(i => (i === index ? 1 : 0.5)),
          });

          return (
            <TouchableOpacity
              key={index}
              accessibilityRole="button"
              accessibilityState={isFocused ? { selected: true } : {}}
              accessibilityLabel={options.tabBarAccessibilityLabel}
              testID={options.tabBarTestID}
              onPress={onPress}
              onLongPress={onLongPress}
              style={styles.tabBarButton}
            >
              <Animated.Text style={{ opacity, fontSize: 16 }}>
                {label}
              </Animated.Text>
            </TouchableOpacity>
          );
        })}
      </View>
    );
  }

  const App = () => {
    return (
      <NavigationContainer>
        <Tab.Navigator
          tabBar={props => <MyTabBar {...props} />}
          screenOptions={{
            tabBarActiveTintColor: '#e91e63',
            tabBarInactiveTintColor: '#222',
            tabBarLabelStyle: { fontSize: 12 },
            tabBarStyle: { backgroundColor: 'powderblue' },
            tabBarIndicatorStyle: { backgroundColor: '#e91e63' },
          }}
        >
          <Tab.Screen
            name="Feed"
            component={Feed}
            options={{ tabBarLabel: 'Feed' }}
          />
          <Tab.Screen
            name="Notifications"
            component={Notifications}
            options={{ tabBarLabel: 'Notifications' }}
          />
          <Tab.Screen
            name="Profile"
            component={Profile}
            options={{ tabBarLabel: 'Profile' }}
          />
        </Tab.Navigator>
      </NavigationContainer>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    tabBarContainer: {
      flexDirection: 'row',
      justifyContent: 'space-around',
      backgroundColor: 'powderblue',
      paddingVertical: 10,
    },
    tabBarButton: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;
}
// Start hare  for top tab navigation 1

{
  import React from 'react';
  import { View, Text, TouchableOpacity, StyleSheet, Dimensions } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createMaterialTopTabNavigator } from '@react-navigation/material-top-tabs';
  import { Animated } from 'react-native';

  // Screens
  const Feed = () => (
    <View style={styles.container}>
      <Text>This is Feed page</Text>
    </View>
  );

  const Notifications = () => (
    <View style={styles.container}>
      <Text>This is Notifications page</Text>
    </View>
  );

  const Profile = () => (
    <View style={styles.container}>
      <Text>This is Profile page</Text>
    </View>
  );

  // Create Tab Navigator
  const Tab = createMaterialTopTabNavigator();

  // Custom Tab Bar Component
  function MyTabBar({ state, descriptors, navigation, position }) {
    const inputRange = state.routes.map((_, i) => i);

    return (
      <View style={styles.tabBarContainer}>
        {state.routes.map((route, index) => {
          const { options } = descriptors[route.key];
          const label =
            options.tabBarLabel !== undefined
              ? options.tabBarLabel
              : options.title !== undefined
                ? options.title
                : route.name;

          const isFocused = state.index === index;

          const onPress = () => {
            const event = navigation.emit({
              type: 'tabPress',
              target: route.key,
              canPreventDefault: true,
            });

            if (!isFocused && !event.defaultPrevented) {
              navigation.navigate(route.name);
            }
          };

          const onLongPress = () => {
            navigation.emit({
              type: 'tabLongPress',
              target: route.key,
            });
          };

          const opacity = position.interpolate({
            inputRange,
            outputRange: inputRange.map(i => (i === index ? 1 : 0.5)),
          });

          return (
            <TouchableOpacity
              key={index}
              accessibilityRole="button"
              accessibilityState={isFocused ? { selected: true } : {}}
              accessibilityLabel={options.tabBarAccessibilityLabel}
              testID={options.tabBarTestID}
              onPress={onPress}
              onLongPress={onLongPress}
              style={styles.tabBarButton}
            >
              <Animated.Text style={{ opacity, fontSize: 16 }}>
                {label}
              </Animated.Text>
            </TouchableOpacity>
          );
        })}
      </View>
    );
  }

  const App = () => {
    return (
      <NavigationContainer>
        <Tab.Navigator
          tabBar={props => <MyTabBar {...props} />}
          screenOptions={{
            tabBarActiveTintColor: '#e91e63',
            tabBarInactiveTintColor: '#222',
            tabBarLabelStyle: { fontSize: 12 },
            tabBarStyle: { backgroundColor: 'powderblue' },
            tabBarIndicatorStyle: { backgroundColor: '#e91e63' },
          }}
        >
          <Tab.Screen
            name="Feed"
            component={Feed}
            options={{ tabBarLabel: 'Feed' }}
          />
          <Tab.Screen
            name="Notifications"
            component={Notifications}
            options={{ tabBarLabel: 'Notifications' }}
          />
          <Tab.Screen
            name="Profile"
            component={Profile}
            options={{ tabBarLabel: 'Profile' }}
          />
        </Tab.Navigator>
      </NavigationContainer>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    tabBarContainer: {
      flexDirection: 'row',
      justifyContent: 'space-around',
      backgroundColor: 'powderblue',
      paddingVertical: 10,
    },
    tabBarButton: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;
}

// Start hare  for tab navigation /  bottom navigation  3

{

  import * as React from 'react';
  import { View, Text, TouchableOpacity, StyleSheet, Button } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

  // Screens
  const HomeScreen = ({ navigation }) => (
    <View style={styles.container}>
      <Text>This is Home page</Text>
      <Button
        title="Go to Jane's profile"
        onPress={() => navigation.navigate('Profile', { name: 'Jane' })}
      />
    </View>
  );

  const ProfileScreen = ({ route }) => (
    <View style={styles.container}>
      <Text>This is Profile page</Text>
      <Text>This is {route.params.name}'s profile</Text>
    </View>
  );

  const Feed = () => (
    <View style={styles.container}>
      <Text>This is Feed page</Text>
    </View>
  );

  const Notifications = () => (
    <View style={styles.container}>
      <Text>This is Notifications page</Text>
    </View>
  );

  const Tab = createBottomTabNavigator();


  function CustomTabBar({ state, descriptors, navigation }) {
    return (
      <View style={styles.tabBarContainer}>
        {state.routes.map((route, index) => {
          const { options } = descriptors[route.key];
          const label =
            options.tabBarLabel !== undefined
              ? options.tabBarLabel
              : options.title !== undefined
                ? options.title
                : route.name;

          const isFocused = state.index === index;

          const onPress = () => {
            const event = navigation.emit({
              type: 'tabPress',
              target: route.key,
              canPreventDefault: true,
            });

            if (!isFocused && !event.defaultPrevented) {
              navigation.navigate(route.name);
            }
          };

          const onLongPress = () => {
            navigation.emit({
              type: 'tabLongPress',
              target: route.key,
            });
          };

          return (
            <TouchableOpacity
              key={index}
              accessibilityRole="button"
              accessibilityState={isFocused ? { selected: true } : {}}
              accessibilityLabel={options.tabBarAccessibilityLabel}
              testID={options.tabBarTestID}
              onPress={onPress}
              onLongPress={onLongPress}
              style={styles.tabBarButton}
            >
              <Text style={{ color: isFocused ? '#673ab7' : '#222' }}>
                {label}
              </Text>
            </TouchableOpacity>
          );
        })}
      </View>
    );
  }


  const App = () => {
    return (
      <NavigationContainer>
        <Tab.Navigator>
          <Tab.Screen name="Home" component={HomeScreen} />
          <Tab.Screen name="Profile" component={ProfileScreen} />
          <Tab.Screen name="Feed" component={Feed} />
          <Tab.Screen name="Notifications" component={Notifications} />
        </Tab.Navigator>
      </NavigationContainer>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;
}
// Start hare  for tab navigation /  bottom navigation  2
{
  import * as React from 'react';
  import { View, Text, TouchableOpacity, StyleSheet, Button } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

  // Screens
  const HomeScreen = ({ navigation }) => (
    <View style={styles.container}>
      <Button
        title="Go to Jane's profile"
        onPress={() => navigation.navigate('Profile', { name: 'Jane' })}
      />
    </View>
  );

  const ProfileScreen = ({ route }) => (
    <View style={styles.container}>
      <Text>This is {route.params.name}'s profile</Text>
    </View>
  );

  const Feed = () => (
    <View style={styles.container}>
      <Text>Feed Screen</Text>
    </View>
  );

  const Notifications = () => (
    <View style={styles.container}>
      <Text>Notifications Screen</Text>
    </View>
  );

  const Profile = () => (
    <View style={styles.container}>
      <Text>Profile Screen</Text>
    </View>
  );

  const Tab = createBottomTabNavigator();

  function CustomTabBar({ state, descriptors, navigation }) {
    return (
      <View style={styles.tabBarContainer}>
        {state.routes.map((route, index) => {
          const { options } = descriptors[route.key];
          const label =
            options.tabBarLabel !== undefined
              ? options.tabBarLabel
              : options.title !== undefined
                ? options.title
                : route.name;

          const isFocused = state.index === index;

          const onPress = () => {
            const event = navigation.emit({
              type: 'tabPress',
              target: route.key,
              canPreventDefault: true,
            });

            if (!isFocused && !event.defaultPrevented) {
              navigation.navigate(route.name, route.params);
            }
          };

          const onLongPress = () => {
            navigation.emit({
              type: 'tabLongPress',
              target: route.key,
            });
          };

          return (
            <TouchableOpacity
              key={index}
              accessibilityRole="button"
              accessibilityState={isFocused ? { selected: true } : {}}
              accessibilityLabel={options.tabBarAccessibilityLabel}
              testID={options.tabBarTestID}
              onPress={onPress}
              onLongPress={onLongPress}
              style={styles.tabBarButton}
            >
              <Text style={{ color: isFocused ? '#673ab7' : '#222' }}>
                {label}
              </Text>
            </TouchableOpacity>
          );
        })}
      </View>
    );
  }

  const App = () => {
    return (
      <NavigationContainer>
        <Tab.Navigator
          tabBar={props => <CustomTabBar {...props} />}
          screenOptions={{
            tabBarStyle: { position: 'absolute' },
          }}
        >
          <Tab.Screen name="Home" component={HomeScreen} />
          <Tab.Screen name="Profile" component={ProfileScreen} />
          <Tab.Screen name="Feed" component={Feed} />
          <Tab.Screen name="Notifications" component={Notifications} />
        </Tab.Navigator>
      </NavigationContainer>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    tabBarContainer: {
      flexDirection: 'row',
      justifyContent: 'space-around',
    },
    tabBarButton: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
  });

  export default App;
}
// Start hare  for tab navigation /  bottom navigation   1
{
  import * as React from 'react';
  import { Text, View, Button } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';


  function HomeScreen({ navigation }) {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Text>Home!</Text>
        <Button
          title="Go to Settings"
          onPress={() => navigation.navigate('Settings')}
        />
      </View>
    );
  }

  function SettingsScreen({ navigation }) {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Text>Settings!</Text>
        <Button title="Go to Home" onPress={() => navigation.navigate('Home')} />
      </View>
    );
  }

  const Tab = createBottomTabNavigator();
  function App() {
    return (
      <NavigationContainer>
        <Tab.Navigator>
          <Tab.Screen name="Home" component={HomeScreen} />
          <Tab.Screen name="Settings" component={SettingsScreen} />
        </Tab.Navigator>
      </NavigationContainer>
    );
  }

  export default App;
}

// Start hare  for tab navigation /  bottom navigation   1
{

  import * as React from 'react';
  import { Text, View } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

  function HomeScreen() {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Text>Home!</Text>
      </View>
    );
  }

  function SettingsScreen() {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Text>Settings!</Text>
      </View>
    );
  }

  const Tab = createBottomTabNavigator();

  function App() {
    return (
      <NavigationContainer>
        <Tab.Navigator>
          <Tab.Screen name="Home" component={HomeScreen} />
          <Tab.Screen name="Settings" component={SettingsScreen} />
        </Tab.Navigator>
      </NavigationContainer>
    );
  }

  export default App;
}

// Start hare  for stack navigation / for moving beetween screen
{
  import * as React from 'react';
  import { Button, View, Text } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createNativeStackNavigator } from '@react-navigation/native-stack';


  const Stack = createNativeStackNavigator();


  function HomeScreen({ navigation }) {
    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <Text>Home Screen</Text>
        <Button
          title="Go to Details"
          onPress={() => navigation.navigate('Details')}
        />
      </View>
    );
  }

  function DetailsScreen() {
    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <Text>Details Screen</Text>
      </View>
    );
  }

  // function DetailsScreen({ navigation }) {
  //   return (
  //     <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
  //       <Text>Details Screen</Text>
  //       <Button
  //         title="Go to Details... again"
  //         onPress={() => navigation.navigate('Details')}
  //       />
  //     </View>
  //   );
  // }

  // function DetailsScreen({ navigation }) {
  //   return (
  //     <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
  //       <Text>Details Screen</Text>
  //       <Button
  //         title="Go to Details... again"
  //         onPress={() => navigation.push('Details')}
  //       />
  //       <Button title="Go to Home" onPress={() => navigation.navigate('Home')} />
  //       <Button title="Go back" onPress={() => navigation.goBack()} />
  //       <Button
  //         title="Go back to first screen in stack"
  //         onPress={() => navigation.popToTop()}
  //       />
  //     </View>
  //   );
  // }


  function App() {
    return (
      <NavigationContainer>
        <Stack.Navigator initialRouteName="Home">
          <Stack.Screen name="Home" component={HomeScreen} />
          <Stack.Screen name="Details" component={DetailsScreen} />
        </Stack.Navigator>
      </NavigationContainer>
    );
  }

  export default App;
}


// Start hare  for stack navigation / for moving beetween screen
{
  import * as React from 'react';
  import { NavigationContainer } from '@react-navigation/native';
  import { createNativeStackNavigator } from '@react-navigation/native-stack';
  import { Button, Text, View } from 'react-native';

  const Stack = createNativeStackNavigator();

  const App = () => {
    return (
      <NavigationContainer>
        <Stack.Navigator>
          <Stack.Screen
            name="Home"
            component={HomeScreen}
            options={{ title: 'Welcome' }}
          />
          <Stack.Screen name="Profile" component={ProfileScreen} />
        </Stack.Navigator>
      </NavigationContainer>
    );
  };

  const HomeScreen = ({ navigation }) => {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Button
          title="Go to Jane's profile"
          onPress={() => navigation.navigate('Profile', { name: 'Jane' })}
        />
      </View>
    );
  };

  const ProfileScreen = ({ route }) => {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Text>This is {route.params.name}'s profile</Text>
      </View>
    );
  };

  export default App;
}
// Start hare

//* my latest final app 
// Start hare


import React, { useEffect, useState } from 'react';
import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal, Image } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [createModalVisible, setCreateModalVisible] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [name, setName] = useState('');
  const [color, setColor] = useState('');
  const [searchText, setSearchText] = useState('');


  //Create user
  const [usermame, setUsername] = useState("");
  const [usercolor, setUsercolor] = useState("");



  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // console.warn(result);
    setData(result);
  }

  useEffect(() => {
    getAPIData();
  }, []);

  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "DELETE"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();
    }
  }

  const updateUser = async () => {
    if (!selectedUser) return;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${selectedUser.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, color })
    });
    result = await result.json();
    if (result) {
      console.warn("User updated");
      setModalVisible(false);
      getAPIData();
    }
  }

  const createUser = async () => {
    const usernameValue = usermame;
    const usercolorValue = usercolor;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        name: usernameValue,
        color: usercolorValue
      })
    });

    result = await result.json();

    if (result) {
      // Optionally, reset the form or perform any other actions
      // Clear name input
      setUsername('');
      // Clear color input
      setUsercolor('');
      // Refresh the user list
      setCreateModalVisible(false);
      getAPIData();
      console.warn("User created:", usernameValue);
    } else {
      console.warn("Failed to create user");
    }
  }




  // const searchUser = async (text) => {
  //   setSearchText(text);
  //   const url = `http://10.0.2.2:3000/users?q=${text}`;
  //   let result = await fetch(url);
  //   result = await result.json();
  //   console.warn("Search result:", result); // Log the result for debugging
  //   setData(result);
  // }

  const searchUser = async (text) => {
    setSearchText(text);
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // Filter data based on search text
    const filteredData = result.filter(user =>
      user.name.toLowerCase().includes(text.toLowerCase()) ||
      user.color.toLowerCase().includes(text.toLowerCase())
    );
    // Set filtered data
    setData(filteredData);
  }


  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  }
  const openCreateModal = () => {
    setCreateModalVisible(true);
    // setSelectedUser(user);
    // setName(user.name);
    // setColor(user.color);
  }

  const imageMap = {
    'FB_IMG_1545560289018.jpg': require('./assets/images/FB_IMG_1545560289018.jpg'),
    // Add more mappings as needed
  };

  const defaultImage = require('./assets/images/default.jpg');


  return (

    <View style={styles.container}>
      <View>
        <TextInput
          style={styles.input}
          placeholder="Search"
          value={searchText}
          onChangeText={(text) => searchUser(text)}
        />
      </View>
      <ScrollView>
        {data.length ? (
          data.map((item) => {
            const imageSource = imageMap[item.image] || defaultImage;
            return (
              <View key={item.id} style={styles.itemContainer}>
                <Text style={styles.itemText}>ID: {item.id}</Text>
                <Text style={styles.itemText}>Name: {item.name}</Text>
                <Text style={styles.itemText}>Color: {item.color}</Text>
                <Image
                  source={imageSource}
                  style={[styles.image, styles.imagepostion]}
                />
                <View style={styles.buttonRow}>
                  <Pressable
                    style={[styles.button, styles.buttonDelete]}
                    onPress={() => deleteUser(item.id)}>
                    <Text style={styles.textStyle}>Delete</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.button, styles.buttonOpen]}
                    onPress={() => openModal(item)}>
                    <Text style={styles.textStyle}>Update</Text>
                  </Pressable>
                </View>
              </View>
            );
          })
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}


        <Pressable
          style={[styles.button, styles.buttonClose]} onPress={() => openCreateModal()}>
          <Text style={styles.textStyle}>Create Users</Text>
        </Pressable>
        {/* <View style={styles.container}>
          <Image
            source={{ uri: 'https://www.shutterstock.com/shutterstock/photos/1876073491/display_1500/stock-photo-white-orchids-in-living-room-in-late-afternoon-light-1876073491.jpg' }}
            style={styles.image}
          />
        </View> */}
        {/* <View style={styles.imagecontainer}>
          <Image
            source={require('./assets/images/FB_IMG_1545560289018.jpg')}
            style={styles.image}
          />
        </View> */}

        <View style={styles.centeredView}>
          {/* model box for update  */}
          <Modal
            animationType="slide"
            transparent={true}
            visible={modalVisible}
            onRequestClose={() => {
              // Alert.alert('Modal has been closed.');
              setModalVisible(!modalVisible);
            }}>
            <View style={styles.centeredView}>
              <View style={styles.modalView}>
                <Text style={styles.modalText}>Update Details</Text>

                <TextInput
                  style={styles.input}
                  placeholder="Name"
                  value={name}
                  onChangeText={setName}
                />
                <TextInput
                  style={styles.input}
                  placeholder="Color"
                  value={color}
                  onChangeText={setColor}
                />

                <Pressable
                  style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                  <Text style={styles.textStyle}>Save</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonClose]}
                  onPress={() => setModalVisible(!modalVisible)}>
                  <Text style={styles.textStyle}>Hide Modal</Text>
                </Pressable>
              </View>
            </View>
          </Modal>

          {/* Create model box for user create  */}
          <Modal
            animationType="slide"
            transparent={true}
            visible={createModalVisible}
            onRequestClose={() => {
              // Alert.alert('Modal has been closed.');
              setCreateModalVisible(!createModalVisible);
            }}>
            <View style={styles.centeredView}>
              <View style={styles.modalView}>
                <Text style={styles.modalText}>Update Details</Text>

                <TextInput
                  style={styles.input}
                  placeholder="Enter Name"
                  value={usermame}
                  onChangeText={(text) => setUsername(text)}
                />
                <TextInput
                  style={styles.input}
                  placeholder="Enter Last Name"
                  value={usercolor}
                  onChangeText={(text) => setUsercolor(text)}
                />

                <Pressable
                  style={[styles.button, styles.buttonSave]} onPress={() => createUser()}>
                  <Text style={styles.textStyle}>Save</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonClose]}
                  onPress={() => setCreateModalVisible(!createModalVisible)}>
                  <Text style={styles.textStyle}>Hide Modal</Text>
                </Pressable>
              </View>
            </View>
          </Modal>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({

  // home page style
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
    // position: 'relative',
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },

  // model style
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 22,
  },

  modalView: {
    margin: 20,
    backgroundColor: 'white',
    borderRadius: 20,
    padding: 35,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
    width: '90%',
  },

  modalText: {
    marginBottom: 15,
    textAlign: 'center',
  },

  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#4CAF50',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  },
  buttonSave: {
    marginBottom: 15,
    backgroundColor: '#4CAF50',
  },
  buttonDelete: {
    backgroundColor: '#ff5c5c',
  },
  textStyle: {
    color: 'white',
    fontWeight: 'bold',
    textAlign: 'center',
  },
  // image 
  image: {
    width: 50,
    height: 50,
    borderRadius: 100, // Optional: Add border radius for rounded corners
  },
  imagecontainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },

  imagepostion: {
    //   position: 'relative',
    position: 'absolute',
    bottom: 95,
    left: 310,
  }


});

export default App;
// Start hare
//* regarding image 

const imageMap = {
  'FB_IMG_1545560289018.jpg': require('./assets/images/FB_IMG_1545560289018.jpg'),
  // Add more mappings as needed
};

const defaultImage = require('./assets/images/default.jpg');

{
  data.length ? (
    data.map((item) => {
      const imageSource = imageMap[item.image] || defaultImage;
      return (
        <View key={item.id} style={styles.itemContainer}>
          <Text style={styles.itemText}>ID: {item.id}</Text>
          <Text style={styles.itemText}>Name: {item.name}</Text>
          <Text style={styles.itemText}>Color: {item.color}</Text>
          <Image
            source={imageSource}
            style={[styles.image, styles.imagepostion]}
          />
          <View style={styles.buttonRow}>
            <Pressable
              style={[styles.button, styles.buttonDelete]}
              onPress={() => deleteUser(item.id)}>
              <Text style={styles.textStyle}>Delete</Text>
            </Pressable>
            <Pressable
              style={[styles.button, styles.buttonOpen]}
              onPress={() => {/* Handle update */ }}>
              <Text style={styles.textStyle}>Update</Text>
            </Pressable>
          </View>
        </View>
      );
    })
  ) : (
    <Text style={styles.noDataText}>No data available</Text>
  )
}


{/* <View style={styles.container}>
          <Image
            source={{ uri: 'https://www.shutterstock.com/shutterstock/photos/1876073491/display_1500/stock-photo-white-orchids-in-living-room-in-late-afternoon-light-1876073491.jpg' }}
            style={styles.image}
          />
        </View> */}
{/* <View style={styles.imagecontainer}>
          <Image
            source={require('./assets/images/FB_IMG_1545560289018.jpg')}
            style={styles.image}
          />
        </View> */}
const styles = StyleSheet.create({
  // image 
  image: {
    width: 50,
    height: 50,
    borderRadius: 100, // Optional: Add border radius for rounded corners
  },
  imagecontainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },

  imagepostion: {
    //   position: 'relative',
    position: 'absolute',
    bottom: 95,
    left: 310,
  }
});

// Start hare
// Start hare
//*  before image data display
// Start hare
{
  data.length ? (
    data.map((item) => (
      <View key={item.id} style={styles.itemContainer}>
        <Text style={styles.itemText}>ID: {item.id}</Text>
        <Text style={styles.itemText}>Name: {item.name}</Text>
        <Text style={styles.itemText}>Color: {item.color}</Text>
        <Image
          source={require('./assets/images/FB_IMG_1545560289018.jpg')}
          style={styles.image}
        />
        <View style={styles.buttonRow}>
          {/* <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" /> */}
          {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
          <Pressable
            style={[styles.button, styles.buttonDelete]}
            onPress={() => deleteUser(item.id)}   >
            <Text style={styles.textStyle}>Delete</Text>
          </Pressable>
          <Pressable
            style={[styles.button, styles.buttonOpen]}
            onPress={() => openModal(item)}>
            <Text style={styles.textStyle}>Update</Text>
          </Pressable>
        </View>
      </View>
    ))
  ) : (
    <Text style={styles.noDataText}>No data available</Text>
  )
}
// Start hare
//*
// Start hare
// Start hare
//* react native crude / regarding crude operation / regarding crude  / create ,delete , update ,read,search 
// Start hare
import React, { useEffect, useState } from 'react';
import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [createModalVisible, setCreateModalVisible] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [name, setName] = useState('');
  const [color, setColor] = useState('');
  const [searchText, setSearchText] = useState('');


  //Create user
  const [usermame, setUsername] = useState("");
  const [usercolor, setUsercolor] = useState("");

  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // console.warn(result);
    setData(result);
  }

  useEffect(() => {
    getAPIData();
  }, []);

  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "DELETE"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();
    }
  }

  const updateUser = async () => {
    if (!selectedUser) return;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${selectedUser.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, color })
    });
    result = await result.json();
    if (result) {
      console.warn("User updated");
      setModalVisible(false);
      getAPIData();
    }
  }

  const createUser = async () => {
    const usernameValue = usermame;
    const usercolorValue = usercolor;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        name: usernameValue,
        color: usercolorValue
      })
    });

    result = await result.json();

    if (result) {
      // Optionally, reset the form or perform any other actions
      // Clear name input
      setUsername('');
      // Clear color input
      setUsername('');
      // Refresh the user list
      setCreateModalVisible(false);
      getAPIData();
      console.warn("User created:", usernameValue);
    } else {
      console.warn("Failed to create user");
    }
  }




  // const searchUser = async (text) => {
  //   setSearchText(text);
  //   const url = `http://10.0.2.2:3000/users?q=${text}`;
  //   let result = await fetch(url);
  //   result = await result.json();
  //   console.warn("Search result:", result); // Log the result for debugging
  //   setData(result);
  // }

  const searchUser = async (text) => {
    setSearchText(text);
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // Filter data based on search text
    const filteredData = result.filter(user =>
      user.name.toLowerCase().includes(text.toLowerCase()) ||
      user.color.toLowerCase().includes(text.toLowerCase())
    );
    // Set filtered data
    setData(filteredData);
  }


  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  }
  const openCreateModal = () => {
    setCreateModalVisible(true);
    // setSelectedUser(user);
    // setName(user.name);
    // setColor(user.color);
  }

  return (
    <View style={styles.container}>
      <View>
        <TextInput
          style={styles.input}
          placeholder="Search"
          value={searchText}
          onChangeText={(text) => searchUser(text)}
        />
      </View>

      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
              <View style={styles.buttonRow}>
                {/* <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" /> */}
                {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
                <Pressable
                  style={[styles.button, styles.buttonDelete]}
                  onPress={() => deleteUser(item.id)}   >
                  <Text style={styles.textStyle}>Delete</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonOpen]}
                  onPress={() => openModal(item)}>
                  <Text style={styles.textStyle}>Update</Text>
                </Pressable>
              </View>
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}


        <Pressable
          style={[styles.button, styles.buttonOpen]} onPress={() => openCreateModal()}>
          <Text style={styles.textStyle}>Create Users</Text>
        </Pressable>

        <View style={styles.centeredView}>
          {/* model box for update  */}
          <Modal
            animationType="slide"
            transparent={true}
            visible={modalVisible}
            onRequestClose={() => {
              // Alert.alert('Modal has been closed.');
              setModalVisible(!modalVisible);
            }}>
            <View style={styles.centeredView}>
              <View style={styles.modalView}>
                <Text style={styles.modalText}>Update Details</Text>

                <TextInput
                  style={styles.input}
                  placeholder="Name"
                  value={name}
                  onChangeText={setName}
                />
                <TextInput
                  style={styles.input}
                  placeholder="Color"
                  value={color}
                  onChangeText={setColor}
                />

                <Pressable
                  style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                  <Text style={styles.textStyle}>Save</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonClose]}
                  onPress={() => setModalVisible(!modalVisible)}>
                  <Text style={styles.textStyle}>Hide Modal</Text>
                </Pressable>
              </View>
            </View>
          </Modal>

          {/* Create model box for user create  */}
          <Modal
            animationType="slide"
            transparent={true}
            visible={createModalVisible}
            onRequestClose={() => {
              // Alert.alert('Modal has been closed.');
              setCreateModalVisible(!createModalVisible);
            }}>
            <View style={styles.centeredView}>
              <View style={styles.modalView}>
                <Text style={styles.modalText}>Update Details</Text>

                <TextInput
                  style={styles.input}
                  placeholder="Enter Name"
                  value={usermame}
                  onChangeText={(text) => setUsername(text)}
                />
                <TextInput
                  style={styles.input}
                  placeholder="Enter Last Name"
                  value={usercolor}
                  onChangeText={(text) => setUsercolor(text)}
                />

                <Pressable
                  style={[styles.button, styles.buttonSave]} onPress={() => createUser()}>
                  <Text style={styles.textStyle}>Save</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonClose]}
                  onPress={() => setCreateModalVisible(!createModalVisible)}>
                  <Text style={styles.textStyle}>Hide Modal</Text>
                </Pressable>
              </View>
            </View>
          </Modal>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  // home page style
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },

  // model style
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 22,
  },

  modalView: {
    margin: 20,
    backgroundColor: 'white',
    borderRadius: 20,
    padding: 35,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
    width: '90%',
  },

  modalText: {
    marginBottom: 15,
    textAlign: 'center',
  },

  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#4CAF50',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  },
  buttonSave: {
    marginBottom: 15,
    backgroundColor: '#4CAF50',
  },
  buttonDelete: {
    backgroundColor: '#ff5c5c',
  },
  textStyle: {
    color: 'white',
    fontWeight: 'bold',
    textAlign: 'center',
  },


});

export default App;
// Start hare
//* regarding warn
// Start hare
console.warn("User created:", result);
console.warn("User created:");
// Start hare

//*  my final project with model box 
// Start hare

import React, { useEffect, useState } from 'react';
import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [name, setName] = useState('');
  const [color, setColor] = useState('');
  const [searchText, setSearchText] = useState('');

  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    console.warn(result);
    setData(result);
  }

  useEffect(() => {
    getAPIData();
  }, []);

  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "DELETE"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();
    }
  }

  const updateUser = async () => {
    if (!selectedUser) return;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${selectedUser.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, color })
    });
    result = await result.json();
    if (result) {
      console.warn("User updated");
      setModalVisible(false);
      getAPIData();
    }
  }

  // const searchUser = async (text) => {
  //   setSearchText(text);
  //   const url = `http://10.0.2.2:3000/users?q=${text}`;
  //   let result = await fetch(url);
  //   result = await result.json();
  //   console.warn("Search result:", result); // Log the result for debugging
  //   setData(result);
  // }

  const searchUser = async (text) => {
    setSearchText(text);
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // Filter data based on search text
    const filteredData = result.filter(user =>
      user.name.toLowerCase().includes(text.toLowerCase()) ||
      user.color.toLowerCase().includes(text.toLowerCase())
    );
    // Set filtered data
    setData(filteredData);
  }


  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  }

  return (
    <View style={styles.container}>
      <View>
        <TextInput
          style={styles.input}
          placeholder="Search"
          value={searchText}
          onChangeText={(text) => searchUser(text)}
        />
      </View>

      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
              <View style={styles.buttonRow}>
                {/* <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" /> */}
                {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
                <Pressable
                  style={[styles.button, styles.buttonDelete]}
                  onPress={() => deleteUser(item.id)}   >
                  <Text style={styles.textStyle}>Delete</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonOpen]}
                  onPress={() => openModal(item)}>
                  <Text style={styles.textStyle}>Update</Text>
                </Pressable>
              </View>
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}


        <View style={styles.centeredView}>
          <Modal
            animationType="slide"
            transparent={true}
            visible={modalVisible}
            onRequestClose={() => {
              // Alert.alert('Modal has been closed.');
              setModalVisible(!modalVisible);
            }}>
            <View style={styles.centeredView}>
              <View style={styles.modalView}>
                <Text style={styles.modalText}>Update Details</Text>

                <TextInput
                  style={styles.input}
                  placeholder="Name"
                  value={name}
                  onChangeText={setName}
                />
                <TextInput
                  style={styles.input}
                  placeholder="Color"
                  value={color}
                  onChangeText={setColor}
                />

                <Pressable
                  style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                  <Text style={styles.textStyle}>Save</Text>
                </Pressable>
                <Pressable
                  style={[styles.button, styles.buttonClose]}
                  onPress={() => setModalVisible(!modalVisible)}>
                  <Text style={styles.textStyle}>Hide Modal</Text>
                </Pressable>
              </View>
            </View>
          </Modal>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  // home page style
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },

  // model style
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 22,
  },

  modalView: {
    margin: 20,
    backgroundColor: 'white',
    borderRadius: 20,
    padding: 35,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
    width: '90%',
  },

  modalText: {
    marginBottom: 15,
    textAlign: 'center',
  },

  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#4CAF50',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  },
  buttonSave: {
    marginBottom: 15,
    backgroundColor: '#4CAF50',
  },
  buttonDelete: {
    backgroundColor: '#ff5c5c',
  },
  textStyle: {
    color: 'white',
    fontWeight: 'bold',
    textAlign: 'center',
  },


});

export default App;
// Start hare
//* regarding model box / regarding modal box 
// Start hare
// Start hare  good model box 

import React, { useState } from 'react';
import { Alert, Button, TextInput, Modal, StyleSheet, Text, Pressable, View } from 'react-native';

const App = () => {
  const [modalVisible, setModalVisible] = useState(false);
  const [input1, setInput1] = useState('');
  const [input2, setInput2] = useState('');

  return (
    <View style={styles.centeredView}>
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => {
          // Alert.alert('Modal has been closed.');
          setModalVisible(!modalVisible);
        }}>
        <View style={styles.centeredView}>
          <View style={styles.modalView}>
            <Text style={styles.modalText}>Hello World!</Text>

            <TextInput
              style={styles.input}
              placeholder="Input 1"
              value={input1}
              onChangeText={setInput1}
            />
            <TextInput
              style={styles.input}
              placeholder="Input 2"
              value={input2}
              onChangeText={setInput2}
            />
            {/* <Button title='Save' color="#4CAF50" /> */}

            <Pressable
              style={[styles.button, styles.buttonSave]}>
              <Text style={styles.textStyle}>Save</Text>
            </Pressable>

            <Pressable
              style={[styles.button, styles.buttonClose]}
              onPress={() => setModalVisible(!modalVisible)}>
              <Text style={styles.textStyle}>Hide Modal</Text>
            </Pressable>
          </View>
        </View>
      </Modal>
      <Pressable
        style={[styles.button, styles.buttonOpen]}
        onPress={() => setModalVisible(true)}>
        <Text style={styles.textStyle}>Show Modal</Text>
      </Pressable>
    </View>
  );
};


const styles = StyleSheet.create({
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 22,
  },
  modalView: {
    margin: 20,
    backgroundColor: 'white',
    borderRadius: 20,
    padding: 35,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
    width: '90%',
  },
  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#F194FF',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  },
  buttonSave: {
    marginBottom: 15,
    backgroundColor: '#4CAF50',
  },
  textStyle: {
    color: 'white',
    fontWeight: 'bold',
    textAlign: 'center',
  },
  modalText: {
    marginBottom: 15,
    textAlign: 'center',
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
});

export default App;
// Start hare
//*  my final project crude 
// Start hare


import React, { useEffect, useState } from 'react';
import { Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [name, setName] = useState('');
  const [color, setColor] = useState('');
  const [searchText, setSearchText] = useState('');

  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    setData(result);
  }

  useEffect(() => {
    getAPIData();
  }, []);

  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "DELETE"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();
    }
  }

  const updateUser = async () => {
    if (!selectedUser) return;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${selectedUser.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, color })
    });
    result = await result.json();
    if (result) {
      console.warn("User updated");
      setModalVisible(false);
      getAPIData();
    }
  }

  // const searchUser = async (text) => {
  //   setSearchText(text);
  //   const url = `http://10.0.2.2:3000/users?q=${text}`;
  //   let result = await fetch(url);
  //   result = await result.json();
  //   console.warn("Search result:", result); // Log the result for debugging
  //   setData(result);
  // }

  const searchUser = async (text) => {
    setSearchText(text);
    // Fetch all data
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // Filter data based on search text
    const filteredData = result.filter(user =>
      user.name.toLowerCase().includes(text.toLowerCase()) ||
      user.color.toLowerCase().includes(text.toLowerCase())
    );
    // Set filtered data
    setData(filteredData);
  }


  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  }

  return (
    <View style={styles.container}>
      <View>
        <TextInput
          style={styles.input}
          placeholder="Search"
          value={searchText}
          onChangeText={(text) => searchUser(text)}
        />
      </View>

      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
              <View style={styles.buttonRow}>
                <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" />
                <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" />
              </View>
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}

        {/* Modal for updating user */}
        <Modal
          animationType="slide"
          transparent={true}
          visible={modalVisible}
          onRequestClose={() => setModalVisible(false)}
        >
          <View style={styles.centeredView}>
            <View style={styles.modalView}>
              <Text style={styles.modalTitle}>Update User</Text>
              <TextInput
                style={styles.input}
                placeholder="Name"
                value={name}
                onChangeText={setName}
              />
              <TextInput
                style={styles.input}
                placeholder="Color"
                value={color}
                onChangeText={setColor}
              />
              <View style={styles.buttonContainer}>
                <Button onPress={() => setModalVisible(false)} title='Close' color="#888" />
                <Button onPress={updateUser} title='Save' color="#4CAF50" />
              </View>
            </View>
          </View>
        </Modal>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
  centeredView: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    marginTop: 22,
  },
  modalView: {
    margin: 20,
    backgroundColor: "white",
    borderRadius: 20,
    padding: 35,
    alignItems: "center",
    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
  },
  modalTitle: {
    fontSize: 20,
    marginBottom: 15,
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },
  buttonContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    width: '100%',
  },
});

export default App;

// Start hare
//*
// Start hare
// Start hare


import React, { useEffect, useState } from 'react';
import { Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [name, setName] = useState('');
  const [color, setColor] = useState('');
  const [searchText, setSearchText] = useState('');

  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // console.warn(result);
    setData(result);
  }

  useEffect(() => {
    getAPIData();
  }, []);

  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "DELETE"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();
    }
  }

  const updateUser = async () => {
    if (!selectedUser) return;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${selectedUser.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, color })
    });
    result = await result.json();
    if (result) {
      console.warn("User updated");
      setModalVisible(false);
      getAPIData();
    }
  }

  // const searchUser = async (text) => {
  //   const url = `"http://10.0.2.2:3000/users?q=${text}`;
  //   console.warn(url);
  //   let result = await fetch(url);
  //   result = await result.json();
  //   if (result) {
  //     setData(result);
  //   }
  // }
  // const searchUser = async (text) => {
  //   setSearchText(text);
  //   const url = `http://10.0.2.2:3000/users?q=${text}`;
  //   console.warn(url);
  //   let result = await fetch(url);
  //   result = await result.json();
  //   setData(result);
  // }
  const searchUser = async (text) => {
    console.warn(text)
    setSearchText(text);
    const url = `http://10.0.2.2:3000/users?q=${text}`;
    let result = await fetch(url);
    result = await result.json();
    console.warn("Search result:", result); // Log the result for debugging
    setData(result);
  }

  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  }

  return (

    <View style={styles.container}>
      <View>
        <TextInput
          style={styles.input}
          placeholder="Search"
          value={searchText}
          onChangeText={(text) => searchUser(text)}
        />
      </View>
      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
              <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" />
              <Button onPress={() => openModal(item)} title='Update' />
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}

        {/* Modal for updating user */}
        <Modal
          animationType="slide"
          transparent={true}
          visible={modalVisible}
          onRequestClose={() => setModalVisible(false)}
        >
          <View style={styles.centeredView}>
            <View style={styles.modalView}>
              <Text style={styles.modalTitle}>Update User</Text>
              <TextInput
                style={styles.input}
                placeholder="Name"
                value={name}
                onChangeText={setName}
              />
              <TextInput
                style={styles.input}
                placeholder="Color"
                value={color}
                onChangeText={setColor}
              />
              <View style={styles.buttonContainer}>
                <Button onPress={() => setModalVisible(false)} title='Close' color="#888" />
                <Button onPress={updateUser} title='Save' color="#4CAF50" />
              </View>
            </View>
          </View>
        </Modal>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
  centeredView: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    marginTop: 22,
  },
  modalView: {
    margin: 20,
    backgroundColor: "white",
    borderRadius: 20,
    padding: 35,
    alignItems: "center",
    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
  },
  modalTitle: {
    fontSize: 20,
    marginBottom: 15,
  },
  input: {
    height: 40,
    // width: '100%',
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
  },
  buttonContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    width: '100%',
  },
});

export default App;

// Start hare
//*


import React, { useEffect, useState } from 'react';
import { Button, Text, TextInput, View, StyleSheet, ScrollView } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    // console.warn(result);
    setData(result);
  }

  useEffect(() => {
    getAPIData();
  }, []);



  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "delete"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();

    }
  }

  const saveAPIData = async () => {
    console.warm(name, color, props.selectedUser.id)
    const url = "http://10.0.2.2:3000/users";
    const id = props.selectedUser.id;
    let result = await fetch(`${url}/${id}`,
      {
        method: "Put",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ name, age, email })
      });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      props.getAPIData();

    }

  }

  return (
    <View style={styles.container}>
      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
              <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" />
              <Button onPress={() => saveAPIData(item.id)} title='Update' />
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}

        <Modal
          animationType="slide"
          transparent={true}
          visible={true}
        >
          <View style={styles.centeredView}>
            <View style={styles.modalView}>
              <Text>Hello World!</Text>
              <Button onPress={() => saveAPIData(item.id)} title='Save' />
            </View>
          </View>
        </Modal>
      </ScrollView>
    </View>
  );
};


const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
});

export default App;
// Start hare
// Start hare
//*
const deleteUser = async (id) => {
  const url = "http://10.0.2.2:3000/users";
  let result = await fetch(`${url}/${id}`, {
    methode: "delete"
  });
  result = await result.json();
  if (result) {
    console.warn("User deleted");
    getAPIData();

  }
}
<Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" />




const saveAPIData = async () => {
  console.warm(name, age, email, props.selectedUser.id)
  const url = "http://10.0.2.2:3000/users";
  const id = props.selectedUser.id;
  let result = await fetch(`${url}/${id}`,
    {
      method: "Put",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, age, email })
    });
  result = await result.json();
  if (result) {
    console.warn("User deleted");
    props.getAPIData();

  }

}
// Start hare
// Start hare
//* regarding calculater 
// Start hare
{

  import React, { useState } from 'react';
  import { Button, Text, TextInput, View, StyleSheet } from 'react-native';

  const App = () => {
    // State to hold the values of the input fields
    const [input1, setInput1] = useState('');
    const [input2, setInput2] = useState('');
    const [input3, setInput3] = useState('');

    // Function to handle button press
    const handlePress = () => {
      // Convert input values to numbers and calculate the total
      const num1 = parseFloat(input1) || 0;
      const num2 = parseFloat(input2) || 0;
      const total = num1 + num2;
      // console.warn(total);
      // alert(total);
      // Update input3 with the total value
      setInput3(total.toString());
    };

    return (
      <View style={styles.container}>
        <Text style={styles.text}>This is my first Application</Text>
        <Text style={styles.label}>Enter first value to add</Text>
        <TextInput
          style={styles.input}
          placeholder="Enter first value"
          keyboardType="numeric"
          value={input1}
          onChangeText={setInput1}
        />
        <Text style={styles.label}>Enter second value to add</Text>
        <TextInput
          style={styles.input}
          placeholder="Enter second value"
          keyboardType="numeric"
          value={input2}
          onChangeText={setInput2}
        />
        <Text style={styles.text}>Total</Text>
        <TextInput
          style={styles.input}
          placeholder="Total will be displayed here"
          value={input3}
          editable={false} // Prevent user from editing this field
        />
        <Button title="Calculate Total" onPress={handlePress} />
      </View>
    );
  };

  // Styles for the components
  const styles = StyleSheet.create({
    container: {
      // backgroundColor:'gray',
      flex: 1,
      padding: 16,
      justifyContent: 'center',
    },
    text: {
      // color:'white',
      fontSize: 30,
      marginBottom: 10,
    },
    label: {
      // color:'white',
      fontSize: 15,
      marginBottom: 10,
    },
    input: {
      height: 40,
      color: 'red',
      borderColor: 'black',
      borderWidth: 1,
      marginBottom: 16,
      paddingHorizontal: 8,
    },
  });

  export default App;
}
// Start hare
// date 08-08-2024
//*  regarding api data get 
// Start hare

import React, { useEffect, useState } from 'react';
import { Button, Text, TextInput, View, StyleSheet, ScrollView } from 'react-native';

const App = () => {
  // State to hold the values of the input fields
  const [input1, setInput1] = useState('');
  const [input2, setInput2] = useState('');
  const [input3, setInput3] = useState('');

  // Function to handle button press
  const handlePress = () => {
    // Convert input values to numbers and calculate the total
    const num1 = parseFloat(input1) || 0;
    const num2 = parseFloat(input2) || 0;
    const total = num1 + num2;
    // console.warn(total);
    // alert(total);
    // Update input3 with the total value
    setInput3(total.toString());
  };

  const [data, setData] = useState([]);
  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    console.warn(result);
    setData(result);
  }

  // const saveAPIData = async () => {
  //   const url = "http://10.0.2.2:3000/users";
  //   let result = await fetch(url,
  //     {
  //       method: "POST",
  //       headers: { "Content-Type": "application/json" }
  //     });
  // }

  useEffect(() => {
    getAPIData();
  }, []);

  return (
    <View style={styles.container}>
      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}
      </ScrollView>
    </View>
  );
};


const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  itemContainer: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  itemText: {
    fontSize: 18,
    color: '#333',
    marginBottom: 4,
  },
  noDataText: {
    fontSize: 18,
    color: '#888',
    textAlign: 'center',
    marginTop: 20,
  },
});

export default App;
// Start hare
//* regarding keyboard
// Start hare
{/* <TextInput keyboardType="default" placeholder="Default Keyboard" />
<TextInput keyboardType="email-address" placeholder="Email Address" />
<TextInput keyboardType="numeric" placeholder="Numeric" />
<TextInput keyboardType="phone-pad" placeholder="Phone Pad" />
<TextInput keyboardType="decimal-pad" placeholder="Decimal Pad" />
<TextInput keyboardType="twitter" placeholder="Twitter" />
<TextInput keyboardType="web-search" placeholder="Web Search" />
<TextInput keyboardType="visible-password" secureTextEntry={true} placeholder="Visible Password" /> */}

// Start hare
//*regarding first code / regarding start
// Start hare 3
// Start hare 2
// Start hare calculater
import React, { useState } from 'react';
import { Button, Text, TextInput, View, StyleSheet } from 'react-native';

const App = () => {
  // State to hold the values of the input fields
  const [input1, setInput1] = useState('');
  const [input2, setInput2] = useState('');
  const [input3, setInput3] = useState('');

  // Function to handle button press
  const handlePress = () => {
    // Convert input values to numbers and calculate the total
    const num1 = parseFloat(input1) || 0;
    const num2 = parseFloat(input2) || 0;
    const total = num1 + num2;
    // console.warn(total);
    // alert(total);
    // Update input3 with the total value
    setInput3(total.toString());
  };

  return (
    <View style={styles.container}>
      <Text style={styles.text}>This is my first Application</Text>
      <Text style={styles.label}>Enter first value to add</Text>
      <TextInput
        style={styles.input}
        placeholder="Enter first value"
        keyboardType="numeric"
        value={input1}
        onChangeText={setInput1}
      />
      <Text style={styles.label}>Enter second value to add</Text>
      <TextInput
        style={styles.input}
        placeholder="Enter second value"
        keyboardType="numeric"
        value={input2}
        onChangeText={setInput2}
      />
      <Text style={styles.text}>Total</Text>
      <TextInput
        style={styles.input}
        placeholder="Total will be displayed here"
        value={input3}
        editable={false} // Prevent user from editing this field
      />
      <Button title="Calculate Total" onPress={handlePress} />
    </View>
  );
};

// Styles for the components
const styles = StyleSheet.create({
  container: {
    // backgroundColor:'gray',
    flex: 1,
    padding: 16,
    justifyContent: 'center',
  },
  text: {
    // color:'white',
    fontSize: 30,
    marginBottom: 10,
  },
  label: {
    // color:'white',
    fontSize: 15,
    marginBottom: 10,
  },
  input: {
    height: 40,
    color: 'red',
    borderColor: 'black',
    borderWidth: 1,
    marginBottom: 16,
    paddingHorizontal: 8,
  },
});

export default App;


// Start hare 2
import React, { useState } from 'react';
import { Button, Text, TextInput, View, StyleSheet } from 'react-native';

const App = () => {
  // State to hold the values of the input fields
  const [input1, setInput1] = useState('');
  const [input2, setInput2] = useState('');

  // Function to handle button press
  const handlePress = () => {
    alert(`Input 1: ${input1}\nInput 2: ${input2}`);
  };

  return (
    <View style={styles.container}>
      <Text style={styles.text}>This is my first Application</Text>
      <TextInput
        style={styles.input}
        placeholder="Enter first value"
        value={input1}
        onChangeText={setInput1}
      />
      <TextInput
        style={styles.input}
        placeholder="Enter second value"
        value={input2}
        onChangeText={setInput2}
      />
      <Button title='Press here' onPress={handlePress} />
    </View>
  );
};

// Styles for the components
const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    justifyContent: 'center',
  },
  text: {
    fontSize: 30,
    marginBottom: 10,
  },
  input: {
    height: 40,
    borderColor: 'black',
    borderWidth: 1,
    marginBottom: 16,
    paddingHorizontal: 8,
  },
});

export default App;



// Start hare 1in app.js file 
import React from 'react';
import { Button, Text, View } from 'react-native';

const App = () => {
  return (
    <View>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Text style={{ fontSize: 30 }} >hi shahid i am don</Text>
      <Button title='Press hare' ></Button>

    </View>
  );
}
export default App;






// 222222222222222222222222222222222222222222222222222222222222222222222
//    04-08-2024
{

  import 'react-native-gesture-handler'; // Import this at the top
  import React from 'react';
  import { Text, View, StyleSheet, TouchableOpacity } from 'react-native';
  import { NavigationContainer } from '@react-navigation/native';
  import { createStackNavigator } from '@react-navigation/stack';

  // Create a Stack Navigator
  const Stack = createStackNavigator();

  // Home Screen Component
  const HomeScreen = ({ navigation }) => {
    return (
      <View style={styles.container}>
        <TouchableOpacity onPress={() => navigation.navigate('Details', { name: 'Shahid', contact: '123-456-7890' })}>
          <Text style={styles.label}>Shahid</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => navigation.navigate('Details', { name: 'Arif', contact: '123-456-7891' })}>
          <Text style={styles.label}>Arif</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => navigation.navigate('Details', { name: 'Moshahid', contact: '123-456-7892' })}>
          <Text style={styles.label}>Moshahid</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => navigation.navigate('Details', { name: 'Hamid', contact: '123-456-7893' })}>
          <Text style={styles.label}>Hamid</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => navigation.navigate('Details', { name: 'Mojahid', contact: '123-456-7894' })}>
          <Text style={styles.label}>Mojahid</Text>
        </TouchableOpacity>
      </View>
    );
  };

  // Details Screen Component
  const DetailsScreen = ({ route }) => {
    const { name, contact } = route.params;

    return (
      <View style={styles.container}>
        <Text style={styles.label}>Name: {name}</Text>
        <Text style={styles.label}>Contact: {contact}</Text>
      </View>
    );
  };

  // Main App Component
  const App = () => {
    return (
      <NavigationContainer>
        <Stack.Navigator>
          <Stack.Screen name="Home" component={HomeScreen} />
          <Stack.Screen name="Details" component={DetailsScreen} />
        </Stack.Navigator>
      </NavigationContainer>
    );
  };

  // Styles for the components
  const styles = StyleSheet.create({
    container: {
      flex: 1,
      padding: 16,
      marginTop: 20,
    },
    label: {
      fontSize: 20,
      marginBottom: 10,
    },
  });

  export default App;
}
2222222222222222222222222222222222222222222222222
// Alert.alert('Modal has been closed.');