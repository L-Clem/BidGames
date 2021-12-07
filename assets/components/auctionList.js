import '../styles/auctionList.css';

import React, { Component, useEffect, useState } from "react";
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';

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
        console.log(items);
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        } else {
            return (
                <ul>
                    <li>
                        <Card className="custom-card color">
                            <Card.Body className="card">
                                <Card.Title>Check out what we have in stock</Card.Title>
                                <Button href ="#" variant="primary">Shop now</Button>
                            </Card.Body>
                        </Card>
                    </li>
                    
                    {items.slice(1, 4).map(item => (
                        <li key={item.id}>
                            <Card className="custom-card">
                                {/* <Card.Img variant="top" src="holder.js/100px180" /> */}
                                <Card.Body>
                                    <Card.Link href="#">{item.title}</Card.Link>
                                    <Card.Text class="price">20 $</Card.Text>
                                    <Card.Text>Card Title</Card.Text>
                                </Card.Body>
                            </Card>
                        </li>
                    ))}
                </ul>
            );
        }

    }
}

