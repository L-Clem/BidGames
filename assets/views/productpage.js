import React, { Component, useEffect, useState } from "react";
import Button from 'react-bootstrap/Button';

export default class ProductPage extends Component {
    
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            items: []
        };
    }

    componentDidMount() {
        let id = this.props.match.params.itemId;

        fetch('http://localhost:8000/api/sales/' + id, {
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
                        item: data
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
        const { error, isLoaded, item } = this.state;
        
        console.log(item);
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        } else {
            return (
                <div>
                    <p>{item.id}</p>
                    <p>{item.title}</p>
                    <p>{item.description}</p>
                </div>
            );
        }
    }
}
