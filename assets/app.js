import './styles/app.css';

import React from 'react';
import ReactDOM from 'react-dom';
import Searchbox from './components/searchbox.js';
import CategoryDropdown from './components/categoryDropdown.js';
import HomepageCarousel from './components/homepageCarousel';
import AuctionList from './components/auctionList';

ReactDOM.render(<Searchbox />, document.getElementById('search-box'));
ReactDOM.render(<CategoryDropdown />, document.getElementById('category-dropdown'));
ReactDOM.render(<HomepageCarousel />, document.getElementById('carousel'));
ReactDOM.render(<AuctionList />, document.getElementById('auction-list1'));
ReactDOM.render(<AuctionList />, document.getElementById('auction-list2'));
