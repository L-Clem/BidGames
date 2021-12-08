import React, { Component, useEffect, useState } from "react";
import Carousel from 'react-bootstrap/Carousel';

export default class HomepageCarousel extends Component {

    render () {
        
        return (
            <Carousel fade variant="dark" dynamicheight="false">
                <Carousel.Item>
                    <img
                    className="d-block w-100"
                    src={require('../images/splash.png')} 
                    alt="First slide"
                    />
                </Carousel.Item>
                <Carousel.Item>
                    <img
                    className="d-block w-100"
                    src={require('../images/splash.png')} 
                    alt="Second slide"
                    />
                </Carousel.Item>
                <Carousel.Item>
                    <img
                    className="d-block w-100"
                    src={require('../images/splash.png')} 
                    alt="Third slide"
                    />
                </Carousel.Item>
            </Carousel>
        );
    }

}