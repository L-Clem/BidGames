import React, { Component } from 'react';
import Homepage from './views/homepage.js';
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";

export default function AppRouter() {
    return (
        <Router>
            <Routes>
                <Route exact path="/app" element={<Homepage />}>
                </Route>
                <Route path="/about" element={<Homepage />}>
                </Route>
                <Route path="/dashboard" element={<Homepage />}>
                </Route>
            </Routes>
        </Router>
    );
}