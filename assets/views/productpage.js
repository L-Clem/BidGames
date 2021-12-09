import '../styles/productpage.css';

import React, { Component, useEffect, useState } from "react";
import Button from 'react-bootstrap/Button';
import Breadcrumb from 'react-bootstrap/Breadcrumb';
import Carousel from 'react-bootstrap/Carousel';
import Form from 'react-bootstrap/Form'
import { useParams } from "react-router-dom";

function ProductPage() {
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [data, setData] = useState([]);
    let params = useParams();

    useEffect(() => {
        const fetchData = async () => {
            const res = await fetch('http://localhost:8000/api/sales/' + params.itemId, {
                method: 'GET',
                headers: {
                    'accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            const json = await res.json();
            setData(json);
            setIsLoaded(true);
        };
        fetchData();
    }, [data.id]);

    if (error) {
        return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
        return <div>Loading...</div>;
    } else {
        return (
            <div key={data.id}>
                <div className="product">
                    <Breadcrumb>
                        <Breadcrumb.Item href="#">Home</Breadcrumb.Item>
                        <Breadcrumb.Item href="#">Category</Breadcrumb.Item>
                        <Breadcrumb.Item active>{data.title}</Breadcrumb.Item>
                    </Breadcrumb>
                    <div className="product-container">
                        <Carousel className="product-carousel">
                            <Carousel.Item>
                                <img
                                    className="d-block w-100"
                                    src={require('../images/poker.jpg')} 
                                    alt="First slide"
                                />
                            </Carousel.Item>
                            <Carousel.Item>
                                <img
                                    className="d-block w-100"
                                    src={require('../images/poker2.jpeg')} 
                                    alt="First slide"
                                />
                            </Carousel.Item>
                            <Carousel.Item>
                                <img
                                    className="d-block w-100"
                                    src={require('../images/poker3.jpg')} 
                                    alt="First slide"
                                />
                            </Carousel.Item>
                        </Carousel>
                        <div className="product-info">
                            <div class="border-bottom">
                                <h2>{data.title}</h2>
                            </div>
                            <div className="product-info-container border-bottom">
                                <p>Condition: Brand new</p>
                                <p>TIme left: 2d 12h 24m 17s</p>
                            </div>
                            <div className="product-info-container">
                                <p>Starting bid: <span className="product-price">€35,00 </span></p>
                                <div>
                                    <Form class="make-bid" action="">
                                        <Form.Control className="bid-input" type="text" placeholder="Bid amount" />
                                        <Button className="bid" variant="success">Place bid</Button>
                                    </Form>
                                </div>
                            </div>
                        </div>
                        <div class="seller-info">
                            <div class="border-bottom">
                                <h5>Seller information:</h5>
                                <a href="#">user123</a>
                            </div>
                            <Button className="favorites" variant="success">Add item to favourites</Button>
                        </div>
                    </div>
                    <div className="product-description">
                        <h2>Description</h2>
                        <p>{data.description}</p>
                    </div>
                </div>
                <div></div>
                
                
            </div>
        );
    }
}

export default ProductPage;
