import React, { Component, useEffect, useState } from "react";
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
export default class AuctionList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            items: []
        };
    }

    componentDidMount() {

        fetch('http://localhost:8000/api/sales', {
            method: 'GET',
            headers: {
                'accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
            .then(res => res.json())
            .then(
                data => {
                    this.setState({
                        isLoaded: true,
                        items: data
                    });
                },

                (error) => {
                    this.setState({
                        isLoaded: true,
                        error
                    });
                }
            )

    }

    render() {
        const { error, isLoaded, items } = this.state;
        let cardClass = 'green-card';
        let cardTitle = 'Check out what we have in stock';

        if (this.props.isRed) {
            cardClass = 'red-card';
            cardTitle = 'Check out current live auctions';
        }
        console.log(items);
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        } else {
            return (
                <div className="auction-list">
                    <div className="list-element">
                        <Card text='light'>
                            <Card.Body className={`card colored-card ${cardClass}`}>
                                <Card.Title>{ cardTitle }</Card.Title>
                                <Button className="card-button" href="#" variant="primary">Shop now →</Button>
                            </Card.Body>
                        </Card>
                    </div>
                    
                    {items.slice(1, 5).map(item => (
                        <div className="list-element" key={item.id}>
                            <Card border="light" className="custom-card">
                                <Card.Img variant="top" src={require('../images/splash.png')}  />
                                <Card.Body>
                                    <Link to={`/items/${item.id}`}>{item.title}</Link>
                                    <Card.Text className="price">20 $</Card.Text>
                                    <Card.Text>Bids: 8</Card.Text>
                                </Card.Body>
                            </Card>
                        </div>
                    ))}
                </div>
            );
        }
    }
}
