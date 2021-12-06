import './styles/app.css';

import React from 'react';
import ReactDOM from 'react-dom';
import Searchbox from './components/searchbox.js'
import CategoryDropdown from './components/categoryDropdown.js'

ReactDOM.render(<Searchbox />, document.getElementById('search-box'));
ReactDOM.render(<CategoryDropdown />, document.getElementById('category-dropdown'));
