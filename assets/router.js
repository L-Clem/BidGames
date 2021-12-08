import React, { Component } from 'react';
import Homepage from './views/homepage.js';
import ProductPage from './views/productpage.js';
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";

export default function AppRouter() {
    return (
        <Router>
            <Routes>
                <Route exact path="/app" element={<Homepage />}/>
                    <Route exact path="items" element={<Homepage />}> 
                        <Route path=":itemId" element={<ProductPage />} />
                    </Route>
            </Routes>
        </Router>
    );
}