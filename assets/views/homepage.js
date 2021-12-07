import '../styles/app.css';
import '../styles/homepage.css';

import React, { Component, useEffect, useState } from "react";
import HomepageCarousel from '../components/homepageCarousel';
import AuctionList from '../components/auctionList';

export default class Homepage extends Component {

    render () {
        return (
            <div className="homepage-content">
                <HomepageCarousel />
                <div>
                    <div className="auction-section">
                        <h2> Recommended auctions</h2>
                        <AuctionList />
                    </div>
                    <div className="auction-section">   
                        <h2>Live auctions</h2>
                        <AuctionList />
                    </div>
                </div>
            </div>
        )
    }
}