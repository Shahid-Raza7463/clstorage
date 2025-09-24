import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import Home from './components/Web/Pages/Home/Home';
import About from './components/Web/Pages/About/About';
import Contact from './components/Web/Pages/Contact/Contact';
import Footer from './components/Web/Pages/Common/Footer';
import NavBar from './components/Web/Pages/Common/NavBar';

import './App.css';

const App = () => {
  const [currentPage, setCurrentPage] = useState('home');

  return (
    <Router>
      <div>
        {/* <NavBar setCurrentPage={setCurrentPage} /> */}
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/about" element={<About />} />
          <Route path="/contact" element={<Contact />} />
        </Routes>
        {/* <Footer /> */}
      </div>
    </Router>
  );
};

export default App;
