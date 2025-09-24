//* dd
//* dd
//* dd
//* dd
//* dd
//* dd
//* dd
//* dd
import React, {useEffect, useState} from 'react';
import {
  Alert,
  Pressable,
  Button,
  Text,
  TextInput,
  View,
  StyleSheet,
  ScrollView,
  Modal,
  Image,
  TouchableOpacity,
} from 'react-native';
import {createDrawerNavigator} from '@react-navigation/drawer';
import {NavigationContainer} from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';

function HomeScreen({navigation}) {
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

function AboutScreen({navigation}) {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>About</Text>
      {/* Text paragraph */}
      <Text style={styles.paragraph}>
        Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer, worked
        @TrakAff as a Laravel backend web developer and currently working as
        Laravel backend web developer @Capitall. I'm proficient in working with
        and implementing backend for web apps using Php, Laravel, MySQL, Ajax,
        JSON, JavaScript, React Js, Node Js, HTML, CSS, jQuery, Bootstrap. And I
        enjoy taking on new challenges. I have 2 years of experience in Backend
        Web Development.
      </Text>
      {/* Navigation button */}
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Settings')}>
        <Text style={styles.buttonText}>Go to Settings</Text>
      </TouchableOpacity>
    </View>
  );
}

function ResumeScreen({navigation}) {
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

function SettingsScreen({navigation}) {
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

function ContactScreen({navigation}) {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [subject, setSubject] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = () => {
    // Handle form submission (API call, validation, etc.)
    console.log('Form Submitted', {name, email, subject, message});
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.headingcontact}>Contact Me</Text>

      {/* Address Info */}
      <View style={styles.infoWrap}>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Address</Text>
          <Text>Laxmi Nagar Metro Station, New Delhi</Text>
        </View>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Call Us</Text>
          <Text>+917488952139</Text>
        </View>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Email Us</Text>
          <Text>shahidraza7463@gmail.com</Text>
        </View>
      </View>

      {/* Contact Form */}
      <View style={styles.form}>
        <TextInput
          style={styles.input}
          placeholder="Your Name"
          value={name}
          onChangeText={setName}
        />
        <TextInput
          style={styles.input}
          placeholder="Your Email"
          value={email}
          onChangeText={setEmail}
        />
        <TextInput
          style={styles.input}
          placeholder="Subject"
          value={subject}
          onChangeText={setSubject}
        />
        <TextInput
          style={[styles.input, styles.textarea]}
          placeholder="Message"
          multiline
          numberOfLines={4}
          value={message}
          onChangeText={setMessage}
        />
        <TouchableOpacity style={styles.buttoncontact} onPress={handleSubmit}>
          <Text style={styles.buttonTextcontact}>Send Message</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
}

function PortfolioScreen({navigation}) {
  const calculaterapp = require('./assets/images/portfolio/project-expertaff1.png');
  return (
    <ScrollView style={styles.containerp}>
      <Text style={styles.headingp}>Portfolio</Text>
      <Text style={styles.paragraphp}>
        Welcome to my portfolio. Here you'll find a collection of projects that
        highlight my expertise in software development and web technologies.
        Each project demonstrates my dedication to creating effective solutions
        and my passion for coding.
      </Text>
      <View style={styles.cardp}>
        <Text style={styles.projectTitlep}>Expertaff</Text>
        <Image source={calculaterapp} style={styles.imagep} />
      </View>

      <TouchableOpacity
        style={styles.buttonp}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonTextp}>Go to Home</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const Drawer = createDrawerNavigator();

// function App() {
//   return (
//     <NavigationContainer>
//       <Drawer.Navigator initialRouteName="Home">
//         <Drawer.Screen name="Home" component={HomeScreen} />
//         <Drawer.Screen name="About" component={AboutScreen} />
//         <Drawer.Screen name="Resume" component={ResumeScreen} />
//         <Drawer.Screen name="Portfolio" component={PortfolioScreen} />
//         <Drawer.Screen name="Contact" component={ContactScreen} />
//         <Drawer.Screen name="Settings" component={SettingsScreen} />
//       </Drawer.Navigator>
//     </NavigationContainer>
//   );
// }

// function App() {
//   return (
//     <NavigationContainer>
//       <Drawer.Navigator
//         initialRouteName="Home"
//         screenOptions={{
//           drawerStyle: styles.drawerStyle, // Drawer container style
//           drawerLabelStyle: styles.drawerLabel, // Drawer label style
//           drawerActiveTintColor: '#fff', // Active label color
//           drawerInactiveTintColor: '#000', // Inactive label color
//           drawerActiveBackgroundColor: '#6200ea', // Active background color
//           drawerItemStyle: styles.drawerItem, // Drawer item spacing
//         }}>
//         <Drawer.Screen name="Home" component={HomeScreen} />
//         <Drawer.Screen name="About" component={AboutScreen} />
//         <Drawer.Screen name="Resume" component={ResumeScreen} />
//         <Drawer.Screen name="Portfolio" component={PortfolioScreen} />
//         <Drawer.Screen name="Contact" component={ContactScreen} />
//         <Drawer.Screen name="Settings" component={SettingsScreen} />
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
          drawerStyle: styles.drawerStyle, // Drawer container style
          drawerLabelStyle: styles.drawerLabel, // Drawer label style
          drawerActiveTintColor: '#fff', // Active label color
          drawerInactiveTintColor: '#000', // Inactive label color
          drawerActiveBackgroundColor: '#6200ea', // Active background color
          drawerItemStyle: styles.drawerItem, // Drawer item spacing
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
  // Main container
  contentcenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
    paddingHorizontal: 16,
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
  // Headings
  heading: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 16,
  },
  // Button group
  buttonGroup: {
    width: '100%',
    alignItems: 'center',
    marginTop: 16,
  },
  // Button styles
  button: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    paddingHorizontal: 24,
    borderRadius: 8,
    marginVertical: 8,
    width: '90%',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {width: 0, height: 2},
    shadowOpacity: 0.3,
    shadowRadius: 3,
    elevation: 4,
  },

  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
  //* About page
  // Paragraph text
  paragraph: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
    marginBottom: 16,
    paddingHorizontal: 10,
  },
  //* About page end
  //* resume page
  container: {
    flex: 1,
    paddingHorizontal: 16,
    backgroundColor: '#f5f5f5',
  },
  sectionTitle: {
    marginVertical: 16,
  },

  paragraphresume: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
  },
  resumeSection: {
    marginVertical: 16,
  },
  resumeTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#6200ee',
    marginBottom: 8,
  },
  resumeItem: {
    marginBottom: 16,
  },
  // Resume Item Details
  subTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#444',
  },
  date: {
    fontSize: 14,
    color: '#777',
    marginBottom: 4,
  },
  text: {
    fontSize: 16,
    color: '#333',
    lineHeight: 22,
  },
  emphasis: {
    fontStyle: 'italic',
  },
  //* resume page end
  //* contact page
  headingcontact: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginVertical: 16,
    textAlign: 'center',
  },
  infoWrap: {
    marginVertical: 20,
  },
  infoItem: {
    marginBottom: 16,
  },
  infoTitle: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  form: {
    marginTop: 16,
  },
  input: {
    height: 50,
    backgroundColor: '#fff',
    paddingLeft: 12,
    marginBottom: 16,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#ddd',
  },
  textarea: {
    height: 120,
  },
  buttoncontact: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    borderRadius: 8,
    alignItems: 'center',
    marginTop: 16,
  },
  buttonTextcontact: {
    color: '#fff',
    fontWeight: 'bold',
  },
  mapEmbed: {
    marginTop: 32,
  },
  map: {
    width: '100%',
    height: 270,
    borderWidth: 0,
    borderRadius: 8,
  },

  // portfolio page
  containerp: {
    flex: 1,
    backgroundColor: '#f9f9f9',
    padding: 16,
  },
  headingp: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    textAlign: 'center',
    marginBottom: 20,
  },
  paragraphp: {
    fontSize: 16,
    color: '#555',
    lineHeight: 24,
    marginBottom: 20,
    textAlign: 'center',
  },
  cardp: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 16,
    marginVertical: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    shadowOffset: {width: 0, height: 3},
    elevation: 4,
  },
  projectTitlep: {
    fontSize: 18,
    fontWeight: '600',
    marginBottom: 10,
    color: '#333',
    textAlign: 'center',
  },
  imagep: {
    width: '100%',
    height: 150,
    borderRadius: 10,
    resizeMode: 'cover',
  },
  buttonp: {
    backgroundColor: '#6200ea',
    paddingVertical: 14,
    paddingHorizontal: 20,
    borderRadius: 10,
    marginTop: 20,
    alignSelf: 'center',
    width: '70%',
    alignItems: 'center',
  },
  buttonTextp: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },
  //* drawer screen styling
  drawerStyle: {
    backgroundColor: '#f5f5f5', // Background color of the drawer
    width: 240, // Width of the drawer
  },
  drawerLabel: {
    fontSize: 16, // Font size of the label
    fontWeight: 'bold', // Font weight
  },
  drawerItem: {
    marginVertical: 5, // Spacing between items
    borderRadius: 5, // Rounded corners for items
  },
  //* drawer screen styling
});
export default App;

//* dd
import {createNativeStackNavigator} from '@react-navigation/native-stack';
//* dd
import React, {useState} from 'react';
import {
  Text,
  View,
  Button,
  StyleSheet,
  Image,
  TouchableOpacity,
  ScrollView,
  TextInput,
} from 'react-native';
import {NavigationContainer} from '@react-navigation/native';
import {createMaterialTopTabNavigator} from '@react-navigation/material-top-tabs';

function HomeScreen({navigation}) {
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

function AboutScreen() {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>About</Text>
      <Text style={styles.paragraph}>
        Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer...
      </Text>
    </View>
  );
}

function ResumeScreen() {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>My Resume</Text>
    </View>
  );
}

function PortfolioScreen() {
  const calculaterapp = require('./assets/images/portfolio/project-expertaff1.png');
  return (
    <ScrollView style={styles.containerp}>
      <Text style={styles.headingp}>Portfolio</Text>
      <Text style={styles.paragraphp}>
        Welcome to my portfolio. Here you'll find a collection of projects...
      </Text>
      <View style={styles.cardp}>
        <Text style={styles.projectTitlep}>Expertaff</Text>
        <Image source={calculaterapp} style={styles.imagep} />
      </View>
    </ScrollView>
  );
}

function ContactScreen() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [subject, setSubject] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = () => {
    console.log('Form Submitted', {name, email, subject, message});
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.headingcontact}>Contact Me</Text>
      <View style={styles.form}>
        <TextInput
          style={styles.input}
          placeholder="Your Name"
          value={name}
          onChangeText={setName}
        />
        <TextInput
          style={styles.input}
          placeholder="Your Email"
          value={email}
          onChangeText={setEmail}
        />
        <TextInput
          style={styles.input}
          placeholder="Subject"
          value={subject}
          onChangeText={setSubject}
        />
        <TextInput
          style={[styles.input, styles.textarea]}
          placeholder="Message"
          multiline
          numberOfLines={4}
          value={message}
          onChangeText={setMessage}
        />
        <TouchableOpacity style={styles.buttoncontact} onPress={handleSubmit}>
          <Text style={styles.buttonTextcontact}>Send Message</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
}

function SettingsScreen() {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>Settings</Text>
    </View>
  );
}

const Tab = createMaterialTopTabNavigator();

function App() {
  return (
    <NavigationContainer>
      <Tab.Navigator
        screenOptions={{
          tabBarLabelStyle: {fontSize: 14},
          tabBarStyle: {backgroundColor: '#6200ee'},
          tabBarIndicatorStyle: {backgroundColor: '#fff'},
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
  // Main container
  contentcenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
    paddingHorizontal: 16,
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
  // Headings
  heading: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 16,
  },
  // Button group
  buttonGroup: {
    width: '100%',
    alignItems: 'center',
    marginTop: 16,
  },
  // Button styles
  button: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    paddingHorizontal: 24,
    borderRadius: 8,
    marginVertical: 8,
    width: '90%',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {width: 0, height: 2},
    shadowOpacity: 0.3,
    shadowRadius: 3,
    elevation: 4,
  },

  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
  //* About page
  // Paragraph text
  paragraph: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
    marginBottom: 16,
    paddingHorizontal: 10,
  },
  //* About page end
  //* resume page
  container: {
    flex: 1,
    paddingHorizontal: 16,
    backgroundColor: '#f5f5f5',
  },
  sectionTitle: {
    marginVertical: 16,
  },

  paragraphresume: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
  },
  resumeSection: {
    marginVertical: 16,
  },
  resumeTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#6200ee',
    marginBottom: 8,
  },
  resumeItem: {
    marginBottom: 16,
  },
  // Resume Item Details
  subTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#444',
  },
  date: {
    fontSize: 14,
    color: '#777',
    marginBottom: 4,
  },
  text: {
    fontSize: 16,
    color: '#333',
    lineHeight: 22,
  },
  emphasis: {
    fontStyle: 'italic',
  },
  //* resume page end
  //* contact page
  headingcontact: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginVertical: 16,
    textAlign: 'center',
  },
  infoWrap: {
    marginVertical: 20,
  },
  infoItem: {
    marginBottom: 16,
  },
  infoTitle: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  form: {
    marginTop: 16,
  },
  input: {
    height: 50,
    backgroundColor: '#fff',
    paddingLeft: 12,
    marginBottom: 16,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#ddd',
  },
  textarea: {
    height: 120,
  },
  buttoncontact: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    borderRadius: 8,
    alignItems: 'center',
    marginTop: 16,
  },
  buttonTextcontact: {
    color: '#fff',
    fontWeight: 'bold',
  },
  mapEmbed: {
    marginTop: 32,
  },
  map: {
    width: '100%',
    height: 270,
    borderWidth: 0,
    borderRadius: 8,
  },

  // portfolio page
  containerp: {
    flex: 1,
    backgroundColor: '#f9f9f9',
    padding: 16,
  },
  headingp: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    textAlign: 'center',
    marginBottom: 20,
  },
  paragraphp: {
    fontSize: 16,
    color: '#555',
    lineHeight: 24,
    marginBottom: 20,
    textAlign: 'center',
  },
  cardp: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 16,
    marginVertical: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    shadowOffset: {width: 0, height: 3},
    elevation: 4,
  },
  projectTitlep: {
    fontSize: 18,
    fontWeight: '600',
    marginBottom: 10,
    color: '#333',
    textAlign: 'center',
  },
  imagep: {
    width: '100%',
    height: 150,
    borderRadius: 10,
    resizeMode: 'cover',
  },
  buttonp: {
    backgroundColor: '#6200ea',
    paddingVertical: 14,
    paddingHorizontal: 20,
    borderRadius: 10,
    marginTop: 20,
    alignSelf: 'center',
    width: '70%',
    alignItems: 'center',
  },
  buttonTextp: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },
});

export default App;

//* dd

import React, {useState} from 'react';
// import * as React from 'react';
import {
  Text,
  View,
  Button,
  StyleSheet,
  Image,
  TouchableOpacity,
  ScrollView,
  TextInput,
} from 'react-native';
import {NavigationContainer} from '@react-navigation/native';
import {createBottomTabNavigator} from '@react-navigation/bottom-tabs';
// import {WebView} from 'react-native-webview';

function HomeScreen({navigation}) {
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

function AboutScreen({navigation}) {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>About</Text>
      {/* Text paragraph */}
      <Text style={styles.paragraph}>
        Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer, worked
        @TrakAff as a Laravel backend web developer and currently working as
        Laravel backend web developer @Capitall. I'm proficient in working with
        and implementing backend for web apps using Php, Laravel, MySQL, Ajax,
        JSON, JavaScript, React Js, Node Js, HTML, CSS, jQuery, Bootstrap. And I
        enjoy taking on new challenges. I have 2 years of experience in Backend
        Web Development.
      </Text>
      {/* Navigation button */}
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Settings')}>
        <Text style={styles.buttonText}>Go to Settings</Text>
      </TouchableOpacity>
    </View>
  );
}

function ResumeScreen({navigation}) {
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

function PortfolioScreen({navigation}) {
  const calculaterapp = require('./assets/images/portfolio/project-expertaff1.png');
  return (
    <ScrollView style={styles.containerp}>
      <Text style={styles.headingp}>Portfolio</Text>
      <Text style={styles.paragraphp}>
        Welcome to my portfolio. Here you'll find a collection of projects that
        highlight my expertise in software development and web technologies.
        Each project demonstrates my dedication to creating effective solutions
        and my passion for coding.
      </Text>
      <View style={styles.cardp}>
        <Text style={styles.projectTitlep}>Expertaff</Text>
        <Image source={calculaterapp} style={styles.imagep} />
      </View>

      <TouchableOpacity
        style={styles.buttonp}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonTextp}>Go to Home</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

function ContactScreen({navigation}) {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [subject, setSubject] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = () => {
    // Handle form submission (API call, validation, etc.)
    console.log('Form Submitted', {name, email, subject, message});
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.headingcontact}>Contact Me</Text>

      {/* Address Info */}
      <View style={styles.infoWrap}>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Address</Text>
          <Text>Laxmi Nagar Metro Station, New Delhi</Text>
        </View>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Call Us</Text>
          <Text>+917488952139</Text>
        </View>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Email Us</Text>
          <Text>shahidraza7463@gmail.com</Text>
        </View>
      </View>

      {/* Contact Form */}
      <View style={styles.form}>
        <TextInput
          style={styles.input}
          placeholder="Your Name"
          value={name}
          onChangeText={setName}
        />
        <TextInput
          style={styles.input}
          placeholder="Your Email"
          value={email}
          onChangeText={setEmail}
        />
        <TextInput
          style={styles.input}
          placeholder="Subject"
          value={subject}
          onChangeText={setSubject}
        />
        <TextInput
          style={[styles.input, styles.textarea]}
          placeholder="Message"
          multiline
          numberOfLines={4}
          value={message}
          onChangeText={setMessage}
        />
        <TouchableOpacity style={styles.buttoncontact} onPress={handleSubmit}>
          <Text style={styles.buttonTextcontact}>Send Message</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
}

function SettingsScreen({navigation}) {
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

const Tab = createBottomTabNavigator();
function App() {
  return (
    <NavigationContainer>
      <Tab.Navigator
        screenOptions={{
          headerStyle: {backgroundColor: '#6200ee'},
          headerTintColor: '#fff',
          tabBarStyle: {backgroundColor: '#6200ee'},
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
  // Main container
  contentcenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
    paddingHorizontal: 16,
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
  // Headings
  heading: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 16,
  },
  // Button group
  buttonGroup: {
    width: '100%',
    alignItems: 'center',
    marginTop: 16,
  },
  // Button styles
  button: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    paddingHorizontal: 24,
    borderRadius: 8,
    marginVertical: 8,
    width: '90%',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {width: 0, height: 2},
    shadowOpacity: 0.3,
    shadowRadius: 3,
    elevation: 4,
  },

  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
  //* About page
  // Paragraph text
  paragraph: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
    marginBottom: 16,
    paddingHorizontal: 10,
  },
  //* About page end
  //* resume page
  container: {
    flex: 1,
    paddingHorizontal: 16,
    backgroundColor: '#f5f5f5',
  },
  sectionTitle: {
    marginVertical: 16,
  },

  paragraphresume: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
  },
  resumeSection: {
    marginVertical: 16,
  },
  resumeTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#6200ee',
    marginBottom: 8,
  },
  resumeItem: {
    marginBottom: 16,
  },
  // Resume Item Details
  subTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#444',
  },
  date: {
    fontSize: 14,
    color: '#777',
    marginBottom: 4,
  },
  text: {
    fontSize: 16,
    color: '#333',
    lineHeight: 22,
  },
  emphasis: {
    fontStyle: 'italic',
  },
  //* resume page end
  //* contact page
  headingcontact: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginVertical: 16,
    textAlign: 'center',
  },
  infoWrap: {
    marginVertical: 20,
  },
  infoItem: {
    marginBottom: 16,
  },
  infoTitle: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  form: {
    marginTop: 16,
  },
  input: {
    height: 50,
    backgroundColor: '#fff',
    paddingLeft: 12,
    marginBottom: 16,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#ddd',
  },
  textarea: {
    height: 120,
  },
  buttoncontact: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    borderRadius: 8,
    alignItems: 'center',
    marginTop: 16,
  },
  buttonTextcontact: {
    color: '#fff',
    fontWeight: 'bold',
  },
  mapEmbed: {
    marginTop: 32,
  },
  map: {
    width: '100%',
    height: 270,
    borderWidth: 0,
    borderRadius: 8,
  },

  // portfolio page
  containerp: {
    flex: 1,
    backgroundColor: '#f9f9f9',
    padding: 16,
  },
  headingp: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    textAlign: 'center',
    marginBottom: 20,
  },
  paragraphp: {
    fontSize: 16,
    color: '#555',
    lineHeight: 24,
    marginBottom: 20,
    textAlign: 'center',
  },
  cardp: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 16,
    marginVertical: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    shadowOffset: {width: 0, height: 3},
    elevation: 4,
  },
  projectTitlep: {
    fontSize: 18,
    fontWeight: '600',
    marginBottom: 10,
    color: '#333',
    textAlign: 'center',
  },
  imagep: {
    width: '100%',
    height: 150,
    borderRadius: 10,
    resizeMode: 'cover',
  },
  buttonp: {
    backgroundColor: '#6200ea',
    paddingVertical: 14,
    paddingHorizontal: 20,
    borderRadius: 10,
    marginTop: 20,
    alignSelf: 'center',
    width: '70%',
    alignItems: 'center',
  },
  buttonTextp: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },
});

export default App;

//* dd

import React, {useState} from 'react';
import {
  Text,
  View,
  Button,
  StyleSheet,
  Image,
  TouchableOpacity,
  ScrollView,
  TextInput,
} from 'react-native';
import {NavigationContainer} from '@react-navigation/native';
import {createMaterialTopTabNavigator} from '@react-navigation/material-top-tabs';

function HomeScreen({navigation}) {
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

function AboutScreen() {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>About</Text>
      <Text style={styles.paragraph}>
        Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer...
      </Text>
    </View>
  );
}

function ResumeScreen() {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>My Resume</Text>
    </View>
  );
}

function PortfolioScreen() {
  const calculaterapp = require('./assets/images/portfolio/project-expertaff1.png');
  return (
    <ScrollView style={styles.containerp}>
      <Text style={styles.headingp}>Portfolio</Text>
      <Text style={styles.paragraphp}>
        Welcome to my portfolio. Here you'll find a collection of projects...
      </Text>
      <View style={styles.cardp}>
        <Text style={styles.projectTitlep}>Expertaff</Text>
        <Image source={calculaterapp} style={styles.imagep} />
      </View>
    </ScrollView>
  );
}

function ContactScreen() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [subject, setSubject] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = () => {
    console.log('Form Submitted', {name, email, subject, message});
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.headingcontact}>Contact Me</Text>
      <View style={styles.form}>
        <TextInput
          style={styles.input}
          placeholder="Your Name"
          value={name}
          onChangeText={setName}
        />
        <TextInput
          style={styles.input}
          placeholder="Your Email"
          value={email}
          onChangeText={setEmail}
        />
        <TextInput
          style={styles.input}
          placeholder="Subject"
          value={subject}
          onChangeText={setSubject}
        />
        <TextInput
          style={[styles.input, styles.textarea]}
          placeholder="Message"
          multiline
          numberOfLines={4}
          value={message}
          onChangeText={setMessage}
        />
        <TouchableOpacity style={styles.buttoncontact} onPress={handleSubmit}>
          <Text style={styles.buttonTextcontact}>Send Message</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
}

function SettingsScreen() {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>Settings</Text>
    </View>
  );
}

const Tab = createMaterialTopTabNavigator();

function App() {
  return (
    <NavigationContainer>
      <Tab.Navigator
        screenOptions={{
          tabBarLabelStyle: {fontSize: 14},
          tabBarStyle: {backgroundColor: '#6200ee'},
          tabBarIndicatorStyle: {backgroundColor: '#fff'},
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
  // Main container
  contentcenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
    paddingHorizontal: 16,
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
  // Headings
  heading: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 16,
  },
  // Button group
  buttonGroup: {
    width: '100%',
    alignItems: 'center',
    marginTop: 16,
  },
  // Button styles
  button: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    paddingHorizontal: 24,
    borderRadius: 8,
    marginVertical: 8,
    width: '90%',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {width: 0, height: 2},
    shadowOpacity: 0.3,
    shadowRadius: 3,
    elevation: 4,
  },

  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
  //* About page
  // Paragraph text
  paragraph: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
    marginBottom: 16,
    paddingHorizontal: 10,
  },
  //* About page end
  //* resume page
  container: {
    flex: 1,
    paddingHorizontal: 16,
    backgroundColor: '#f5f5f5',
  },
  sectionTitle: {
    marginVertical: 16,
  },

  paragraphresume: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
  },
  resumeSection: {
    marginVertical: 16,
  },
  resumeTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#6200ee',
    marginBottom: 8,
  },
  resumeItem: {
    marginBottom: 16,
  },
  // Resume Item Details
  subTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#444',
  },
  date: {
    fontSize: 14,
    color: '#777',
    marginBottom: 4,
  },
  text: {
    fontSize: 16,
    color: '#333',
    lineHeight: 22,
  },
  emphasis: {
    fontStyle: 'italic',
  },
  //* resume page end
  //* contact page
  headingcontact: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginVertical: 16,
    textAlign: 'center',
  },
  infoWrap: {
    marginVertical: 20,
  },
  infoItem: {
    marginBottom: 16,
  },
  infoTitle: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  form: {
    marginTop: 16,
  },
  input: {
    height: 50,
    backgroundColor: '#fff',
    paddingLeft: 12,
    marginBottom: 16,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#ddd',
  },
  textarea: {
    height: 120,
  },
  buttoncontact: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    borderRadius: 8,
    alignItems: 'center',
    marginTop: 16,
  },
  buttonTextcontact: {
    color: '#fff',
    fontWeight: 'bold',
  },
  mapEmbed: {
    marginTop: 32,
  },
  map: {
    width: '100%',
    height: 270,
    borderWidth: 0,
    borderRadius: 8,
  },

  // portfolio page
  containerp: {
    flex: 1,
    backgroundColor: '#f9f9f9',
    padding: 16,
  },
  headingp: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    textAlign: 'center',
    marginBottom: 20,
  },
  paragraphp: {
    fontSize: 16,
    color: '#555',
    lineHeight: 24,
    marginBottom: 20,
    textAlign: 'center',
  },
  cardp: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 16,
    marginVertical: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    shadowOffset: {width: 0, height: 3},
    elevation: 4,
  },
  projectTitlep: {
    fontSize: 18,
    fontWeight: '600',
    marginBottom: 10,
    color: '#333',
    textAlign: 'center',
  },
  imagep: {
    width: '100%',
    height: 150,
    borderRadius: 10,
    resizeMode: 'cover',
  },
  buttonp: {
    backgroundColor: '#6200ea',
    paddingVertical: 14,
    paddingHorizontal: 20,
    borderRadius: 10,
    marginTop: 20,
    alignSelf: 'center',
    width: '70%',
    alignItems: 'center',
  },
  buttonTextp: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },
});

export default App;

//* dd

module.exports = {
  presets: ['module:metro-react-native-babel-preset'],
  plugins: [
    'react-native-reanimated/plugin',
    '@babel/plugin-transform-class-properties',
    '@babel/plugin-transform-private-methods',
    '@babel/plugin-transform-private-property-in-object',
  ],
};

module.exports = {
  presets: ['module:metro-react-native-babel-preset'],
  plugins: ['react-native-reanimated/plugin'],
};



// ddd

module.exports = {
  presets: ['module:@react-native/babel-preset'],
};

module.exports = {
  presets: ['module:metro-react-native-babel-preset'],
  plugins: ['react-native-reanimated/plugin'],
};

module.exports = {
  presets: ['module:metro-react-native-babel-preset'],
  plugins: [
    'react-native-reanimated/plugin',
    '@babel/plugin-transform-private-methods'
  ],
};

//* dd
// module.exports = {
//   presets: ['module:@react-native/babel-preset'],
// };

module.exports = {
  presets: ['module:metro-react-native-babel-preset'],
  plugins: [
    'react-native-reanimated/plugin',
    '@babel/plugin-transform-class-properties',
    '@babel/plugin-transform-private-methods',
    '@babel/plugin-transform-private-property-in-object',
  ],
};
//* dd
// module.exports = {
//   presets: ['module:metro-react-native-babel-preset'],
// };

module.exports = {
  presets: [
    'module:metro-react-native-babel-preset',
  ],
  plugins: [
    'react-native-reanimated/plugin',
  ],
};
//* dd

function App() {

  const styles = StyleSheet.create({
    // Main container
    contentcenter: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      backgroundColor: '#f5f5f5',
      paddingHorizontal: 16,
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
    // Headings
    heading: {
      fontSize: 24,
      fontWeight: 'bold',
      color: '#333',
      marginBottom: 16,
    },
    // Button group
    buttonGroup: {
      width: '100%',
      alignItems: 'center',
      marginTop: 16,
    },
    // Button styles
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
    //* About page
    // Paragraph text
    paragraph: {
      fontSize: 16,
      color: '#555',
      textAlign: 'justify',
      lineHeight: 22,
      marginBottom: 16,
      paddingHorizontal: 10,
    },
    //* About page end
    //* resume page
    container: {
      flex: 1,
      paddingHorizontal: 16,
      backgroundColor: '#f5f5f5',
    },
    sectionTitle: {
      marginVertical: 16,
    },

    paragraphresume: {
      fontSize: 16,
      color: '#555',
      textAlign: 'justify',
      lineHeight: 22,
    },
    resumeSection: {
      marginVertical: 16,
    },
    resumeTitle: {
      fontSize: 20,
      fontWeight: 'bold',
      color: '#6200ee',
      marginBottom: 8,
    },
    resumeItem: {
      marginBottom: 16,
    },
    // Resume Item Details
    subTitle: {
      fontSize: 18,
      fontWeight: 'bold',
      color: '#444',
    },
    date: {
      fontSize: 14,
      color: '#777',
      marginBottom: 4,
    },
    text: {
      fontSize: 16,
      color: '#333',
      lineHeight: 22,
    },
    emphasis: {
      fontStyle: 'italic',
    },
    //* resume page end
    //* contact page
    headingcontact: {
      fontSize: 24,
      fontWeight: 'bold',
      color: '#333',
      marginVertical: 16,
      textAlign: 'center',
    },
    infoWrap: {
      marginVertical: 20,
    },
    infoItem: {
      marginBottom: 16,
    },
    infoTitle: {
      fontWeight: 'bold',
      fontSize: 16,
    },
    form: {
      marginTop: 16,
    },
    input: {
      height: 50,
      backgroundColor: '#fff',
      paddingLeft: 12,
      marginBottom: 16,
      borderRadius: 8,
      borderWidth: 1,
      borderColor: '#ddd',
    },
    textarea: {
      height: 120,
    },
    buttoncontact: {
      backgroundColor: '#6200ee',
      paddingVertical: 12,
      borderRadius: 8,
      alignItems: 'center',
      marginTop: 16,
    },
    buttonTextcontact: {
      color: '#fff',
      fontWeight: 'bold',
    },
    mapEmbed: {
      marginTop: 32,
    },
    map: {
      width: '100%',
      height: 270,
      borderWidth: 0,
      borderRadius: 8,
    },

    // portfolio page
    containerp: {
      flex: 1,
      backgroundColor: '#f9f9f9',
      padding: 16,
    },
    headingp: {
      fontSize: 28,
      fontWeight: 'bold',
      color: '#333',
      textAlign: 'center',
      marginBottom: 20,
    },
    paragraphp: {
      fontSize: 16,
      color: '#555',
      lineHeight: 24,
      marginBottom: 20,
      textAlign: 'center',
    },
    cardp: {
      backgroundColor: '#fff',
      borderRadius: 10,
      padding: 16,
      marginVertical: 10,
      shadowColor: '#000',
      shadowOpacity: 0.1,
      shadowRadius: 5,
      shadowOffset: { width: 0, height: 3 },
      elevation: 4,
    },
    projectTitlep: {
      fontSize: 18,
      fontWeight: '600',
      marginBottom: 10,
      color: '#333',
      textAlign: 'center',
    },
    imagep: {
      width: '100%',
      height: 150,
      borderRadius: 10,
      resizeMode: 'cover',
    },
    buttonp: {
      backgroundColor: '#6200ea',
      paddingVertical: 14,
      paddingHorizontal: 20,
      borderRadius: 10,
      marginTop: 20,
      alignSelf: 'center',
      width: '70%',
      alignItems: 'center',
    },
    buttonTextp: {
      color: '#fff',
      fontSize: 16,
      fontWeight: '600',
    },
  });

  export default App;
  //* dd
  <View style={styles.socialLinks}>
    <Text style={styles.socialHeading}>Follow Us</Text>
    <View style={styles.icons}>
      <TouchableOpacity
        onPress={() => openURL('https://wa.me/917488952139')}
        style={styles.iconButton}>
        <Icon name="whatsapp" size={24} color="#25D366" />
      </TouchableOpacity>
      <TouchableOpacity
        onPress={() =>
          openURL(
            'https://www.facebook.com/share/UbuEW2ucYCpR4MBK/?mibextid=qi2Omg',
          )
        }
        style={styles.iconButton}>
        <Icon name="facebook" size={24} color="#3b5998" />
      </TouchableOpacity>
      <TouchableOpacity
        onPress={() => openURL('#')}
        style={styles.iconButton}>
        <Icon name="instagram" size={24} color="#C13584" />
      </TouchableOpacity>
      <TouchableOpacity
        onPress={() =>
          openURL('https://github.com/Shahid-Raza7463?tab=repositories')
        }
        style={styles.iconButton}>
        <Icon name="github" size={24} color="#000" />
      </TouchableOpacity>
      <TouchableOpacity
        onPress={() =>
          openURL('https://www.linkedin.com/in/mdshahidraza7886')
        }
        style={styles.iconButton}>
        <Icon name="linkedin" size={24} color="#0077B5" />
      </TouchableOpacity>
    </View>
  </View>

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      padding: 16,
      backgroundColor: '#fff',
    },
    description: {
      marginBottom: 24,
    },
    subHeading: {
      fontSize: 20,
      fontWeight: 'bold',
    },
    paragraph: {
      fontSize: 16,
      marginTop: 8,
      color: '#333',
    },
    bold: {
      fontWeight: 'bold',
    },
    socialLinks: {
      alignItems: 'center',
      marginTop: 16,
    },
    socialHeading: {
      fontSize: 18,
      fontWeight: 'bold',
      marginBottom: 8,
    },
    icons: {
      flexDirection: 'row',
      justifyContent: 'center',
      marginTop: 8,
    },
    iconButton: {
      marginHorizontal: 8,
    },
  });
  //* dd
  import React from 'react';
  import {
    View,
    Text,
    StyleSheet,
    ScrollView,
    TouchableOpacity,
    Linking,
    Image,
  } from 'react-native';

  const ExpertaffDetailsScreen = () => {
    const expertAff1 = require('../assets/images/portfolio/project-expertaff1.png');
    const expertAff2 = require('../assets/images/portfolio/project-expertaff1.png');
    const expertAff3 = require('../assets/images/portfolio/project-expertaff1.png');
    const expertAff4 = require('../assets/images/portfolio/project-expertaff1.png');

    const openURL = url => {
      Linking.openURL(url).catch(err => console.error("Couldn't load page", err));
    };
    const images = [expertAff1, expertAff2, expertAff3, expertAff4];

    return (
      <ScrollView style={styles.container}>
        <View style={styles.section}>
          <View style={styles.portfolioInfo}>
            <Text style={styles.heading}>Project Information</Text>
            <View>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Project Title: </Text>ExpertAff
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Category: </Text>Web design
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Company: </Text>TrakAff-Affiliate
                Tracking Software
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Project Date: </Text>01 October,
                2023
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Tools & Technologies: </Text>
                Php, Laravel, Mysql, Ajax, Json, JavaScript, HTML, CSS, jQuery,
                Bootstrap
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Project URL: </Text>
                <Text
                  style={styles.link}
                  onPress={() => openURL('https://www.expertaff.com')}>
                  https://www.expertaff.com
                </Text>
              </Text>
            </View>
          </View>
        </View>

        <View style={styles.section}>
          <Text style={styles.heading}>Project Images</Text>
          <View style={styles.imageContainer}>
            {images.map((image, index) => (
              <View key={index} style={styles.card}>
                <Image source={image} style={styles.image} />
              </View>
            ))}
          </View>
        </View>

        <View style={styles.description}>
          <Text style={styles.subHeading}>
            <Text style={styles.bold}>ExpertAff:</Text>
          </Text>
          <Text style={styles.paragraph}>
            ExpertAff is a platform designed for network listing, where users can
            create and manage affiliate networks. It allows users to create
            networks, leave reviews, and respond to them. The system includes
            features like login, signup, and forgot password functionality. The
            navbar contains various tabs:
          </Text>
          <Text style={styles.note}>
            <Text style={styles.noteBold}>Note: </Text>
            Admin can manage all front-end functionalities through the admin
            dashboard.
          </Text>

          <View style={styles.list}>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Add Network/Program: </Text>
              Allows users to create new networks.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Networks: </Text>
              View and manage all listed networks in one place.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Offers: </Text>
              Lists all available offers related to the networks.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Resources: </Text>
              Provides resources related to affiliate marketing.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Reviews: </Text>
              Allows users to give reviews on networks and reply to them.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Blog: </Text>
              Users can create and browse blogs related to affiliate marketing.
            </Text>
          </View>

          <Text style={styles.paragraph}>
            Additionally, the platform offers the ability to:
          </Text>
          <View style={styles.list}>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Rate Networks: </Text>
              Users can rate networks to give feedback on their performance and
              overall experience.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Sponsored Ads: </Text>
              The platform includes space for sponsored advertisements, allowing
              for promotional content display.
            </Text>
          </View>
          <Text style={styles.paragraph}>
            This project provides a comprehensive platform for managing and
            interacting with affiliate networks.
          </Text>
        </View>
      </ScrollView>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: '#f7f7f7',
      padding: 20,
    },
    section: {
      marginBottom: 20,
    },
    portfolioInfo: {
      backgroundColor: '#fff',
      padding: 20,
      borderRadius: 10,
      shadowColor: '#000',
      shadowOpacity: 0.1,
      shadowOffset: { width: 0, height: 4 },
      shadowRadius: 12,
      elevation: 4,
    },
    heading: {
      fontSize: 20,
      fontWeight: 'bold',
      marginBottom: 10,
    },
    infoItem: {
      marginBottom: 8,
      fontSize: 14,
      lineHeight: 20,
    },
    infoTitle: {
      fontWeight: 'bold',
    },
    link: {
      color: '#0040f0',
      textDecorationLine: 'underline',
    },
    description: {
      backgroundColor: '#fff',
      padding: 20,
      borderRadius: 10,
      fontSize: 14,
      lineHeight: 24,
    },
    subHeading: {
      fontSize: 16,
      fontWeight: 'bold',
      marginBottom: 10,
    },
    bold: {
      fontWeight: 'bold',
    },
    paragraph: {
      marginBottom: 10,
      lineHeight: 24,
    },
    note: {
      marginTop: 10,
      marginBottom: 10,
    },
    noteBold: {
      color: '#0040f0',
      fontWeight: 'bold',
    },
    list: {
      marginTop: 10,
    },
    listItem: {
      marginBottom: 8,
      lineHeight: 24,
    },

    imageContainer: {
      flexDirection: 'row',
      flexWrap: 'wrap',
      justifyContent: 'space-between',
    },
    card: {
      backgroundColor: '#fff',
      borderRadius: 10,
      marginBottom: 15,
      padding: 10,
      shadowColor: '#000',
      shadowOpacity: 0.1,
      shadowOffset: { width: 0, height: 4 },
      shadowRadius: 8,
      elevation: 4,
      width: '48%',
      alignItems: 'center',
    },
    image: {
      width: '100%',
      height: 120,
      borderRadius: 10,
      resizeMode: 'cover',
    },
  });

  export default ExpertaffDetailsScreen;

  //* dd
  //* dd


  import React from 'react';
  import {
    View,
    Text,
    StyleSheet,
    ScrollView,
    TouchableOpacity,
    Linking,
  } from 'react-native';
  import Styles from './common/Styles';

  // const ExpertaffDetailsScreen = ({navigation}) => {
  //   return (
  //     <View style={[Styles.contentcenter]}>
  //       <Text style={Styles.heading}>Expertaff</Text>
  //       {/* Text paragraph */}
  //       <Text style={Styles.paragraph}>This is my expertaff project</Text>
  //       {/* Navigation button */}
  //       <TouchableOpacity
  //         style={Styles.button}
  //         onPress={() => navigation.navigate('Home')}>
  //         <Text style={Styles.buttonText}>Go to Home</Text>
  //       </TouchableOpacity>
  //     </View>
  //   );
  // };

  const ExpertaffDetailsScreen = () => {
    const openURL = url => {
      Linking.openURL(url).catch(err => console.error("Couldn't load page", err));
    };

    return (
      <ScrollView style={styles.container}>
        <View style={styles.section}>
          <View style={styles.portfolioInfo}>
            <Text style={styles.heading}>Project Information</Text>
            <View>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Project Title: </Text>ExpertAff
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Category: </Text>Web design
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Company: </Text>TrakAff-Affiliate
                Tracking Software
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Project Date: </Text>01 October,
                2023
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Tools & Technologies: </Text>
                Php, Laravel, Mysql, Ajax, Json, JavaScript, HTML, CSS, jQuery,
                Bootstrap
              </Text>
              <Text style={styles.infoItem}>
                <Text style={styles.infoTitle}>Project URL: </Text>
                <Text
                  style={styles.link}
                  onPress={() => openURL('https://www.expertaff.com')}>
                  https://www.expertaff.com
                </Text>
              </Text>
            </View>
          </View>
        </View>

        <View style={styles.description}>
          <Text style={styles.subHeading}>
            <Text style={styles.bold}>ExpertAff:</Text>
          </Text>
          <Text style={styles.paragraph}>
            ExpertAff is a platform designed for network listing, where users can
            create and manage affiliate networks. It allows users to create
            networks, leave reviews, and respond to them. The system includes
            features like login, signup, and forgot password functionality. The
            navbar contains various tabs:
          </Text>
          <Text style={styles.note}>
            <Text style={styles.noteBold}>Note: </Text>
            Admin can manage all front-end functionalities through the admin
            dashboard.
          </Text>

          <View style={styles.list}>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Add Network/Program: </Text>
              Allows users to create new networks.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Networks: </Text>
              View and manage all listed networks in one place.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Offers: </Text>
              Lists all available offers related to the networks.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Resources: </Text>
              Provides resources related to affiliate marketing.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Reviews: </Text>
              Allows users to give reviews on networks and reply to them.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Blog: </Text>
              Users can create and browse blogs related to affiliate marketing.
            </Text>
          </View>

          <Text style={styles.paragraph}>
            Additionally, the platform offers the ability to:
          </Text>
          <View style={styles.list}>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Rate Networks: </Text>
              Users can rate networks to give feedback on their performance and
              overall experience.
            </Text>
            <Text style={styles.listItem}>
              <Text style={styles.bold}>Sponsored Ads: </Text>
              The platform includes space for sponsored advertisements, allowing
              for promotional content display.
            </Text>
          </View>
          <Text style={styles.paragraph}>
            This project provides a comprehensive platform for managing and
            interacting with affiliate networks.
          </Text>
        </View>
      </ScrollView>
    );
  };

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: '#f7f7f7',
      padding: 20,
    },
    section: {
      marginBottom: 20,
    },
    portfolioInfo: {
      backgroundColor: '#fff',
      padding: 20,
      borderRadius: 10,
      shadowColor: '#000',
      shadowOpacity: 0.1,
      shadowOffset: { width: 0, height: 4 },
      shadowRadius: 12,
      elevation: 4,
    },
    heading: {
      fontSize: 20,
      fontWeight: 'bold',
      marginBottom: 10,
    },
    infoItem: {
      marginBottom: 8,
      fontSize: 14,
      lineHeight: 20,
    },
    infoTitle: {
      fontWeight: 'bold',
    },
    link: {
      color: '#0040f0',
      textDecorationLine: 'underline',
    },
    description: {
      backgroundColor: '#fff',
      padding: 20,
      borderRadius: 10,
      fontSize: 14,
      lineHeight: 24,
    },
    subHeading: {
      fontSize: 16,
      fontWeight: 'bold',
      marginBottom: 10,
    },
    bold: {
      fontWeight: 'bold',
    },
    paragraph: {
      marginBottom: 10,
      lineHeight: 24,
    },
    note: {
      marginTop: 10,
      marginBottom: 10,
    },
    noteBold: {
      color: '#0040f0',
      fontWeight: 'bold',
    },
    list: {
      marginTop: 10,
    },
    listItem: {
      marginBottom: 8,
      lineHeight: 24,
    },
  });

  export default ExpertaffDetailsScreen;

  //* dd



  //* dd
  import React from 'react';
  import { View, Text, StyleSheet } from 'react-native';

  function CalculatorDetailsScreen() {
    return (
      <View style={styles.container}>
        <Text style={styles.title}>Calculator App</Text>
        <Text style={styles.description}>
          This is my first application that I created. I used technologies like:
        </Text>
        <Text style={styles.technology}>- React Native</Text>
        <Text style={styles.technology}>- Node.js</Text>
        <Text style={styles.technology}>- CSS</Text>
      </View>
    );
  }

  const styles = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
      padding: 20,
      backgroundColor: '#f9f9f9',
    },
    title: {
      fontSize: 24,
      fontWeight: 'bold',
      marginBottom: 10,
    },
    description: {
      fontSize: 16,
      textAlign: 'center',
      marginBottom: 20,
    },
    technology: {
      fontSize: 16,
      marginVertical: 5,
    },
  });

  export default CalculatorDetailsScreen;

//* dd


<div class="container">

<div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
        <li data-filter="*" class="filter-active">All</li>
        <li data-filter=".filter-product">Product</li>
        {{-- <li data-filter=".filter-branding">Branding</li> --}}
        <li data-filter=".filter-books">Books</li>
        {{-- <li data-filter=".filter-app">App</li> --}}
        <li data-filter="#">App</li>
    </ul><!--End Portfolio Filters-- >

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

        {{-- <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
            <div class="portfolio-content h-100">
                <img src="{{ asset('img\portfolio\project-vsa (2).png') }}" class="img-fluid"
                    alt="">
                <div class="portfolio-info">
                    <h4>Virtual Data Room</h4>
                    <p>A VDR is a secure online repository for storing and sharing
                        confidential documents.</p>
                    <a href="{{ asset('img/portfolio/project-vsa (2).png') }}"
                        data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                            class="bi bi-zoom-in"></i></a>
                    <a href="{{ url('/portfolio-details/8') }}" title="More Details"
                        class="details-link">
                        <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div><!--End Portfolio Item-- > --}}

        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
            <div class="portfolio-content h-100">
                <img src="{{ asset('img\portfolio\project-portfolio (2).png') }}" class="img-fluid"
                    alt="">
                <div class="portfolio-info">
                    <h4>Portfolio</h4>
                    <p>My aim to provide a clear and organized overview of my work and experiences.</p>
                    <a href="{{ asset('img/portfolio/project-portfolio (2).png') }}"
                        data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                            class="bi bi-zoom-in"></i></a>
                    <a href="{{ url('/portfolio-details/10') }}" title="More Details"
                        class="details-link">
                        <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div><!--End Portfolio Item-- >


    
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
            <div class="portfolio-content h-100">
                <img src="{{ asset('img/portfolio/books-3.jpg') }}" class="img-fluid"
                    alt="">
                <div class="portfolio-info">
                    <h4>Books 3</h4>
                    <p>Lorem ipsum, dolor sit amet consectetur</p>
                    <a href="{{ asset('img/portfolio/books-3.jpg') }}" title="Branding 3"
                        data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                            class="bi bi-zoom-in"></i></a>
                    <a href="{{ url('/portfolio-details') }}" title="More Details"
                        class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
            </div>
        </div><!--End Portfolio Item-- > --}}

    </div >< !--End Portfolio Container-- >

</div >

</div > maine is section ko copy kiya hai androide application ke liye jisme mujhe image ka height bdhana tha to ye raha vo section < div class="container" >
  <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
    {{-- < ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
    <li data-filter="*" class="filter-active">All</li>
    <li data-filter=".filter-product">Product</li>
    <li data-filter=".filter-books">Books</li>
    <li data-filter="#">App</li>
  </> --}}
    <div class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
        <h5>Androide Applications</h5>
    </div>

    <hr />

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">


        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
            <div class="portfolio-content h-100">
                <div style="background-color: red;height: 28rem;width: 98%;" class="col-lg-4 col-md-6">
                    <img src="{{ asset('img\portfolio\project-portfolio (2).png') }}"
                        style=" height: 446px;width: 290px;" alt=""class="">
                </div>
                <div class="portfolio-info">
                    <h4>Portfolio</h4>
                    <p>My aim to provide a clear and organized overview of my work and experiences.</p>
                    <a href="{{ asset('img/portfolio/project-portfolio (2).png') }}"
                        data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                            class="bi bi-zoom-in"></i></a>
                    <a href="{{ url('/portfolio-details/10') }}" title="More Details"
                        class="details-link">
                        <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div><!-- End Portfolio Item -->


       

        {{-- <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
            <div class="portfolio-content h-100">
                <img src="{{ asset('img/portfolio/branding-2.jpg') }}" class="img-fluid"
                    alt="">
                <div class="portfolio-info">
                    <h4>Branding 2</h4>
                    <p>Lorem ipsum, dolor sit amet consectetur</p>
                    <a href="{{ asset('img/portfolio/branding-2.jpg') }}" title="Branding 2"
                        data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                            class="bi bi-zoom-in"></i></a>
                    <a href="{{ url('/portfolio-details') }}" title="More Details"
                        class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
            </div>
        </div><!--End Portfolio Item-- >
       

        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
            <div class="portfolio-content h-100">
                <img src="{{ asset('img/portfolio/books-3.jpg') }}" class="img-fluid"
                    alt="">
                <div class="portfolio-info">
                    <h4>Books 3</h4>
                    <p>Lorem ipsum, dolor sit amet consectetur</p>
                    <a href="{{ asset('img/portfolio/books-3.jpg') }}" title="Branding 3"
                        data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                            class="bi bi-zoom-in"></i></a>
                    <a href="{{ url('/portfolio-details') }}" title="More Details"
                        class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
            </div>
        </div><!--End Portfolio Item-- > --}}

    </div >< !--End Portfolio Container-- >

</div >

</div > ab iska responsness hat gya hai please is is trah design karo ki responsive ho jaye
//* dd
import React, { useState } from 'react';
// import * as React from 'react';
import {
  Text,
  View,
  Button,
  StyleSheet,
  Image,
  TouchableOpacity,
  ScrollView,
  TextInput,
  FlatList,
} from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
// import {WebView} from 'react-native-webview';

const projects = [
  {
    id: '1',
    title: 'Portfolio',
    description: 'A collection of my work and experiences.',
    image: require('./assets/images/FB_IMG_1545560289018.jpg'), // Replace with your local assets
  },
  {
    id: '2',
    title: 'ExpertAff',
    description: 'A network listing site.',
    image: require('./assets/images/FB_IMG_1545560289018.jpg'),
  },
  // Add more projects here...
];

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

// function AboutScreen({navigation}) {
//   return (
//     <View style={[styles.contentcenter]}>
//       <Text style={styles.heading}>About Me</Text>
//       <TouchableOpacity
//         style={styles.button}
//         onPress={() => navigation.navigate('Home')}>
//         <Text style={styles.buttonText}>Go to Home</Text>
//       </TouchableOpacity>
//     </View>
//   );
// }

function AboutScreen({ navigation }) {
  return (
    <View style={[styles.contentcenter]}>
      <Text style={styles.heading}>About</Text>
      {/* Text paragraph */}
      <Text style={styles.paragraph}>
        Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer, worked
        @TrakAff as a Laravel backend web developer and currently working as
        Laravel backend web developer @Capitall. I'm proficient in working with
        and implementing backend for web apps using Php, Laravel, MySQL, Ajax,
        JSON, JavaScript, React Js, Node Js, HTML, CSS, jQuery, Bootstrap. And I
        enjoy taking on new challenges. I have 2 years of experience in Backend
        Web Development.
      </Text>
      {/* Navigation button */}
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonText}>Go to Home</Text>
      </TouchableOpacity>
    </View>
  );
}

// function ResumeScreen({navigation}) {
//   return (
//     <View style={[styles.contentcenter]}>
//       <Text style={styles.heading}>My Resume</Text>
//       <TouchableOpacity
//         style={styles.button}
//         onPress={() => navigation.navigate('Home')}>
//         <Text style={styles.buttonText}>Go to Home</Text>
//       </TouchableOpacity>
//     </View>
//   );
// }

function ResumeScreen({ navigation }) {
  return (
    <ScrollView style={styles.container}>
      <View style={styles.sectionTitle}>
        <Text style={styles.heading}>Resume</Text>
        <Text style={styles.paragraphresume}>
          Passionate and experienced Backend Web Developer with a solid
          foundation in full-stack development. Skilled in a variety of
          technologies, from PHP and Laravel to React and Node.js, I am driven
          to build innovative web solutions that meet and exceed client
          expectations. My journey in web development has been marked by a
          commitment to continuous learning and adapting to the latest industry
          trends. Below is a summary of my professional experience, education,
          skills, and certifications.
        </Text>
      </View>

      <View style={styles.container}>
        {/* Objective */}
        <View style={styles.resumeSection}>
          <Text style={styles.resumeTitle}>Objective</Text>
          <Text style={styles.paragraph}>
            Experienced Backend Web Developer with a passion for developing
            innovative web applications. Skilled in full-stack development,
            including front-end and back-end technologies. Seeking to use my
            skills and experience to contribute to a dynamic web development
            team.
          </Text>
        </View>

        {/* Education */}
        <View style={styles.resumeSection}>
          <Text style={styles.resumeTitle}>Education</Text>
          <View style={styles.resumeItem}>
            <Text style={styles.subTitle}>
              Master of Computer Applications (MCA)
            </Text>
            <Text style={styles.date}>2023 - 2025</Text>
            <Text style={styles.text}>
              <Text style={styles.emphasis}>
                Chandigarh University, Punjab.
              </Text>{' '}
              Grade: 7.30 CGPA
            </Text>
          </View>

          <View style={styles.resumeItem}>
            <Text style={styles.subTitle}>
              Bachelor of Computer Applications (BCA)
            </Text>
            <Text style={styles.date}>2019 - 2022</Text>
            <Text style={styles.text}>
              <Text style={styles.emphasis}>
                International School of Management, Patna
              </Text>
              , affiliated with Aryabhatta Knowledge University
            </Text>
            <Text style={styles.text}>Grade: 7.48 CGPA</Text>
          </View>

          <View style={styles.resumeItem}>
            <Text style={styles.subTitle}>Intermediate in Science</Text>
            <Text style={styles.date}>2017 - 2019</Text>
            <Text style={styles.text}>
              <Text style={styles.emphasis}>
                Saryu High School, Sursand, Sitamarhi
              </Text>
              , affiliated with Bihar School Examination Board
            </Text>
            <Text style={styles.text}>Percentage: 71.8%</Text>
          </View>

          <View style={styles.resumeItem}>
            <Text style={styles.subTitle}>Matriculation (10th)</Text>
            <Text style={styles.date}>2016 - 2017</Text>
            <Text style={styles.text}>
              <Text style={styles.emphasis}>
                Saryu High School, Sursand, Sitamarhi
              </Text>
              , affiliated with Bihar School Examination Board
            </Text>
            <Text style={styles.text}>Percentage: 64.2%</Text>
          </View>
        </View>

        {/* Technical Skills */}
        <View style={styles.resumeSection}>
          <Text style={styles.resumeTitle}>Technical Skills</Text>
          <Text style={styles.paragraph}>
            Programming Languages, Tools & Technologies, and Frameworks &
            Libraries: PHP, Laravel, MySQL, AJAX, JSON, JavaScript, React.js,
            Node.js, HTML, CSS, jQuery, Bootstrap, Git, and C Programming.
          </Text>
        </View>

        {/* Professional Experience */}
        <View style={styles.resumeSection}>
          <Text style={styles.resumeTitle}>Professional Experience</Text>
          <View style={styles.resumeItem}>
            <Text style={styles.subTitle}>Laravel Backend Web Developer</Text>
            <Text style={styles.date}>29-09-2023 - Present</Text>
            <Text style={styles.text}>
              <Text style={styles.emphasis}>
                Capitall India Private Limited, New Delhi
              </Text>
            </Text>
            <Text style={styles.paragraph}>
              - Developed the VSA Data Room.{'\n'}- Developed Balance
              Confirmation project.{'\n'}- Acquired basic knowledge in React.js,
              Node.js, and React Native.{'\n'}- Collaborated with clients to
              deliver successful projects based on their specifications.{'\n'}-
              Gained valuable experience in software testing.
            </Text>
          </View>

          <View style={styles.resumeItem}>
            <Text style={styles.subTitle}>
              Laravel Backend Web Developer Intern
            </Text>
            <Text style={styles.date}>01-03-2023 - 26-09-2023</Text>
            <Text style={styles.text}>
              <Text style={styles.emphasis}>
                TrakAff - Affiliate Tracking Software, New Delhi
              </Text>
            </Text>
            <Text style={styles.paragraph}>
              - Developed the Dynamic Expertaff web application projects.{'\n'}-
              Developed the Dynamic Linktester web application projects.{'\n'}-
              Gained expertise in PHP, Laravel, MySQL, AJAX, JSON, JavaScript.
            </Text>
          </View>
        </View>

        {/* Certifications & Training */}
        <View style={styles.resumeSection}>
          <Text style={styles.resumeTitle}>Certifications & Training</Text>
          <Text style={styles.paragraph}>
            - Certificate of Appreciation for Frontend Web Development - Issued
            by DevTown, 2022.{'\n'}- Certificate of Completion in Frontend Web
            Development Bootcamp - Issued by DevTown, 2022.{'\n'}- Masterclass
            on JavaScript Bootcamp - Issued by Scaler Academy, 2022.{'\n'}-
            Certificate of Completion in PHP Language - Issued by Great
            Learning, 2023.
          </Text>
        </View>
      </View>
      <View style={[styles.contentcenter]}>
        <TouchableOpacity
          style={styles.button}
          onPress={() => navigation.navigate('Home')}>
          <Text style={styles.buttonText}>Go to Home</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
}

// function PortfolioScreen({navigation}) {
//   return (
//     <View style={[styles.contentcenter]}>
//       <Text style={styles.heading}>My Portfolio</Text>
//       <TouchableOpacity
//         style={styles.button}
//         onPress={() => navigation.navigate('Home')}>
//         <Text style={styles.buttonText}>Go to Home</Text>
//       </TouchableOpacity>
//     </View>
//   );
// }

function PortfolioScreen({ navigation }) {
  const renderProject = ({ item }) => (
    <View style={styles.projectCard}>
      <Image source={item.image} style={styles.projectImage} />
      <Text style={styles.projectTitle}>{item.title}</Text>
      <Text style={styles.projectDescription}>{item.description}</Text>
      <TouchableOpacity
        style={styles.detailsButton}
        onPress={() =>
          navigation.navigate('ProjectDetails', { projectId: item.id })
        }>
        <Text style={styles.detailsButtonText}>View Details</Text>
      </TouchableOpacity>
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.heading}>My Portfolio</Text>
      {projects.length > 0 ? (
        <FlatList
          data={projects}
          keyExtractor={item => item.id}
          renderItem={renderProject}
        />
      ) : (
        <Text style={styles.noProjectsText}>No Projects Available</Text>
      )}
    </View>
  );
}

// function ContactScreen({navigation}) {
//   return (
//     <View style={[styles.contentcenter]}>
//       <Text style={styles.heading}>Contact Me</Text>
//       <TouchableOpacity
//         style={styles.button}
//         onPress={() => navigation.navigate('Home')}>
//         <Text style={styles.buttonText}>Go to Home</Text>
//       </TouchableOpacity>
//     </View>
//   );
// }
function ContactScreen({ navigation }) {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [subject, setSubject] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = () => {
    // Handle form submission (API call, validation, etc.)
    console.log('Form Submitted', { name, email, subject, message });
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.headingcontact}>Contact Me</Text>

      {/* Address Info */}
      <View style={styles.infoWrap}>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Address</Text>
          <Text>Laxmi Nagar Metro Station, New Delhi</Text>
        </View>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Call Us</Text>
          <Text>+917488952139</Text>
        </View>
        <View style={styles.infoItem}>
          <Text style={styles.infoTitle}>Email Us</Text>
          <Text>shahidraza7463@gmail.com</Text>
        </View>
      </View>

      {/* Contact Form */}
      <View style={styles.form}>
        <TextInput
          style={styles.input}
          placeholder="Your Name"
          value={name}
          onChangeText={setName}
        />
        <TextInput
          style={styles.input}
          placeholder="Your Email"
          value={email}
          onChangeText={setEmail}
        />
        <TextInput
          style={styles.input}
          placeholder="Subject"
          value={subject}
          onChangeText={setSubject}
        />
        <TextInput
          style={[styles.input, styles.textarea]}
          placeholder="Message"
          multiline
          numberOfLines={4}
          value={message}
          onChangeText={setMessage}
        />
        <TouchableOpacity style={styles.buttoncontact} onPress={handleSubmit}>
          <Text style={styles.buttonTextcontact}>Send Message</Text>
        </TouchableOpacity>
      </View>

      {/* Google Map Embed */}
      {/* <View style={styles.mapEmbed}>
        <Text>Location on Map:</Text>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.974898484312!2d77.27280758321282!3d28.630514405676287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfcad2277af7d%3A0xe68dd5cbcfe7d692!2sLaxmi%20Nagar%20Metro%20Station!5e0!3m2!1sen!2sus!4v1725388219908!5m2!1sen!2sus"
          style={styles.map}
          allowFullScreen
          loading="lazy"></iframe>
      </View> */}
      {/* <View style={styles.containermap}>
        <Text>Location on Map:</Text>
        <WebView
          source={{
            uri: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.974898484312!2d77.27280758321282!3d28.630514405676287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfcad2277af7d%3A0xe68dd5cbcfe7d692!2sLaxmi%20Nagar%20Metro%20Station!5e0!3m2!1sen!2sus!4v1725388219908!5m2!1sen!2sus',
          }}
          style={styles.mapstyle}
        />
      </View> */}
    </ScrollView>
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
  // Main container
  contentcenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
    paddingHorizontal: 16,
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
  // Headings
  heading: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 16,
  },
  // Button group
  buttonGroup: {
    width: '100%',
    alignItems: 'center',
    marginTop: 16,
  },
  // Button styles
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
  //* About page
  // Paragraph text
  paragraph: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
    marginBottom: 16,
    paddingHorizontal: 10,
  },
  //* About page end
  //* resume page
  container: {
    flex: 1,
    paddingHorizontal: 16,
    backgroundColor: '#f5f5f5',
  },
  sectionTitle: {
    marginVertical: 16,
  },

  paragraphresume: {
    fontSize: 16,
    color: '#555',
    textAlign: 'justify',
    lineHeight: 22,
  },
  resumeSection: {
    marginVertical: 16,
  },
  resumeTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#6200ee',
    marginBottom: 8,
  },
  resumeItem: {
    marginBottom: 16,
  },
  // Resume Item Details
  subTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#444',
  },
  date: {
    fontSize: 14,
    color: '#777',
    marginBottom: 4,
  },
  text: {
    fontSize: 16,
    color: '#333',
    lineHeight: 22,
  },
  emphasis: {
    fontStyle: 'italic',
  },
  //* resume page end
  //* contact page
  headingcontact: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginVertical: 16,
    textAlign: 'center',
  },
  infoWrap: {
    marginVertical: 20,
  },
  infoItem: {
    marginBottom: 16,
  },
  infoTitle: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  form: {
    marginTop: 16,
  },
  input: {
    height: 50,
    backgroundColor: '#fff',
    paddingLeft: 12,
    marginBottom: 16,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#ddd',
  },
  textarea: {
    height: 120,
  },
  buttoncontact: {
    backgroundColor: '#6200ee',
    paddingVertical: 12,
    borderRadius: 8,
    alignItems: 'center',
    marginTop: 16,
  },
  buttonTextcontact: {
    color: '#fff',
    fontWeight: 'bold',
  },
  mapEmbed: {
    marginTop: 32,
  },
  map: {
    width: '100%',
    height: 270,
    borderWidth: 0,
    borderRadius: 8,
  },

  // map
  // containermap: {
  //   flex: 1,
  //   justifyContent: 'center',
  //   alignItems: 'center',
  //   padding: 10,
  // },
  // mapstyle: {
  //   width: '100%',
  //   height: 300, // Adjust this value based on your design
  // },

  // portfolio page

  projectCard: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3, // For Android shadow
  },
  projectImage: { height: 150, width: '100%', borderRadius: 8, marginBottom: 8 },
  projectTitle: { fontSize: 18, fontWeight: 'bold', marginBottom: 4 },
  projectDescription: { fontSize: 14, color: '#666', marginBottom: 8 },
  detailsButton: { backgroundColor: '#007BFF', padding: 8, borderRadius: 4 },
  detailsButtonText: { color: '#fff', textAlign: 'center' },
  noProjectsText: {
    fontSize: 16,
    color: '#888',
    textAlign: 'center',
    marginTop: 50,
  },
});

export default App;

//* dd
import * as React from 'react';
import { Text, View, StyleSheet, Image, TouchableOpacity } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import Icon from 'react-native-vector-icons/MaterialIcons'; // Install this package

// Home Screen
function HomeScreen({ navigation }) {
  const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg');
  return (
    <View style={styles.contentcenter}>
      <Text style={styles.heading}>Welcome to My Portfolio</Text>
      <Image source={defaultImage} style={styles.image} />
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
          <Text style={styles.buttonText}>Settings</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
}

// About Screen
function AboutScreen({ navigation }) {
  return (
    <View style={styles.contentcenter}>
      <Text style={styles.heading}>About Me</Text>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonText}>Go to Home</Text>
      </TouchableOpacity>
    </View>
  );
}

// Resume Screen
function ResumeScreen({ navigation }) {
  return (
    <View style={styles.contentcenter}>
      <Text style={styles.heading}>My Resume</Text>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonText}>Go to Home</Text>
      </TouchableOpacity>
    </View>
  );
}

// Portfolio Screen
function PortfolioScreen({ navigation }) {
  return (
    <View style={styles.contentcenter}>
      <Text style={styles.heading}>My Portfolio</Text>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonText}>Go to Home</Text>
      </TouchableOpacity>
    </View>
  );
}

// Contact Screen
function ContactScreen({ navigation }) {
  return (
    <View style={styles.contentcenter}>
      <Text style={styles.heading}>Contact Me</Text>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonText}>Go to Home</Text>
      </TouchableOpacity>
    </View>
  );
}

// Settings Screen
function SettingsScreen({ navigation }) {
  return (
    <View style={styles.contentcenter}>
      <Text style={styles.heading}>Settings</Text>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('Home')}>
        <Text style={styles.buttonText}>Go to Home</Text>
      </TouchableOpacity>
    </View>
  );
}

// Navigation Setup
const Tab = createBottomTabNavigator();

function App() {
  return (
    <NavigationContainer>
      <Tab.Navigator
        screenOptions={({ route }) => ({
          headerStyle: { backgroundColor: '#6200ee' },
          headerTintColor: '#fff',
          tabBarStyle: { backgroundColor: '#6200ee' },
          tabBarActiveTintColor: '#fff',
          tabBarInactiveTintColor: '#ddd',
          tabBarIcon: ({ color, size }) => {
            let iconName;
            if (route.name === 'Home') {
              iconName = 'home';
            } else if (route.name === 'About') {
              iconName = 'info';
            } else if (route.name === 'Resume') {
              iconName = 'description';
            } else if (route.name === 'Portfolio') {
              iconName = 'work';
            } else if (route.name === 'Contact') {
              iconName = 'contacts';
            } else if (route.name === 'Settings') {
              iconName = 'settings';
            }
            return <Icon name={iconName} size={size} color={color} />;
          },
        })}>
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

// Styles
const styles = StyleSheet.create({
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
  image: {
    width: 100,
    height: 100,
    borderRadius: 50,
    marginVertical: 16,
    borderWidth: 2,
    borderColor: '#6200ee',
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
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default App;

//* dd

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

//* dd
import * as React from 'react';
import { Text, View, Button, StyleSheet, Image } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

function HomeScreen({ navigation }) {
  const defaultImage = require('./assets/images/FB_IMG_1545560289018.jpg');
  return (
    <View style={[styles.contentcenter]}>
      <Text>Profile Image</Text>
      <Image source={defaultImage} style={[styles.image]} />
      <Button title="About" onPress={() => navigation.navigate('About')} />
      <Button title="Resume" onPress={() => navigation.navigate('Resume')} />
      <Button
        title="Portfolio"
        onPress={() => navigation.navigate('Portfolio')}
      />
      <Button title="Contact" onPress={() => navigation.navigate('Contact')} />
      <Button
        title="Go to Settings"
        onPress={() => navigation.navigate('Settings')}
      />
    </View>
  );
}

function SettingsScreen({ navigation }) {
  return (
    <View style={[styles.contentcenter]}>
      <View style={[styles.buttonstyle]}>
        <Button
          title="Go to Home"
          onPress={() => navigation.navigate('Home')}
        />
      </View>
    </View>
  );
}
function AboutScreen({ navigation }) {
  return (
    <View style={[styles.contentcenter]}>
      <View style={[styles.buttonstyle]}>
        <Button
          title="Go to Home"
          onPress={() => navigation.navigate('Home')}
        />
      </View>
    </View>
  );
}
function ResumeScreen({ navigation }) {
  return (
    <View style={[styles.contentcenter]}>
      <View style={[styles.buttonstyle]}>
        <Button
          title="Go to Home"
          onPress={() => navigation.navigate('Home')}
        />
      </View>
    </View>
  );
}
function PortfolioScreen({ navigation }) {
  return (
    <View style={[styles.contentcenter]}>
      <View style={[styles.buttonstyle]}>
        <Button
          title="Go to Home"
          onPress={() => navigation.navigate('Home')}
        />
      </View>
    </View>
  );
}
function ContactScreen({ navigation }) {
  return (
    <View style={[styles.contentcenter]}>
      <View style={[styles.buttonstyle]}>
        <Button
          title="Go to Home"
          onPress={() => navigation.navigate('Home')}
        />
      </View>
    </View>
  );
}

const Tab = createBottomTabNavigator();
function App() {
  return (
    <NavigationContainer>
      <Tab.Navigator>
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
    width: 50,
    height: 50,
    borderRadius: 100, // Optional: Add border radius for rounded corners
  },
  imagecontainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },

  // content center
  contentcenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },

  buttonstyle: {
    height: 40,
    width: 400,
    color: 'red',
    borderColor: 'black',
    borderWidth: 1,
    marginBottom: 16,
    paddingHorizontal: 8,
  },
});
export default App;

//* dd

import React, { useEffect, useState } from 'react';
import { View, StyleSheet, Text } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true); // Add loading state
  const [error, setError] = useState(null); // Add error state

  const getAPIData = async () => {

    try {
      const url = 'https://jsonplaceholder.typicode.com/posts';
      // console.warn('Fetching data from:', url);
      let response = await fetch(url);
      console.warn('Response Status:', response); // Log status code
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      let result = await response.json();
      console.warn('Fetched Data:', result); // Log fetched data
      setData(result);
      setLoading(false);
    } catch (error) {
      console.error('There was a problem with the fetch operation:', error);
      setError(error.message);
      setLoading(false);
    }
  };

  useEffect(() => {
    getAPIData();
  }, []);

  return (
    <View style={styles.container}>
      <Text>Home Screen 3</Text>
      {loading && <Text>Loading...</Text>}
      {error && <Text style={styles.errorText}>Error: {error}</Text>}
      {data.length > 0 && (
        <Text>Data fetched successfully: {JSON.stringify(data[0])}</Text>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  errorText: {
    color: 'red',
    marginTop: 10,
  },
});

export default App;

//* dd
import * as React from 'react';
import { Button, View, StyleSheet } from 'react-native';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { NavigationContainer } from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';

function HomeScreen({ navigation }) {
  return (
    <LinearGradient
      colors={['#ff69b4', '#87ceeb', '#ff6347']} // Pink, Blue, Red
      style={styles.gradient}
    >
      <View style={styles.container}>
        <Button
          onPress={() => navigation.navigate('Notifications')}
          title="Go to notifications"
        />
      </View>
    </LinearGradient>
  );
}

function NotificationsScreen({ navigation }) {
  return (
    <View style={styles.container}>
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
  gradient: {
    flex: 1,
  },
});

export default App;

//* dd





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

      {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
      <Pressable
        style={[styles.button, styles.buttonOpen]}
        onPress={() => setModalVisible(true)}>
        <Text style={styles.textStyle}>Update</Text>
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







2222222222222222222222222222222222
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
  };

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
  };

  const searchUser = async (text) => {
    setSearchText(text);
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    const filteredData = result.filter(user =>
      user.name.toLowerCase().includes(text.toLowerCase()) ||
      user.color.toLowerCase().includes(text.toLowerCase())
    );
    setData(filteredData);
  };

  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  };

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

        <Modal
          animationType="slide"
          transparent={true}
          visible={modalVisible}
          onRequestClose={() => {
            setModalVisible(!modalVisible);
          }}>
          <View style={styles.centeredView}>
            <View style={styles.modalView}>
              <Text style={styles.modalText}>Update User</Text>
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
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
  },
  itemContainer: {
    marginBottom: 15,
    padding: 10,
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 10,
  },
  itemText: {
    fontSize: 16,
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  noDataText: {
    textAlign: 'center',
    fontSize: 18,
    marginTop: 20,
  },
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
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
