import logo from './logo.svg';
import './App.css';
import MapComponent from "./components/map/MapComponent";
import React from "react";

function App() {
  return (
    <div className="App">
      <header className="App-header">
          <MapComponent/>
      </header>
    </div>
  );
}

export default App;
