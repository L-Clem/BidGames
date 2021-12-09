import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Searchbox from './components/searchbox.js';
import CategoryDropdown from './components/categoryDropdown.js';
import AppRouter from './router'

ReactDOM.render(<Searchbox />, document.getElementById('search-box'));
ReactDOM.render(<CategoryDropdown />, document.getElementById('category-dropdown'));
ReactDOM.render(<AppRouter />, document.getElementById('root'));
