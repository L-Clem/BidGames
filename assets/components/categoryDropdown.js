import React, { Component, useEffect, useState } from "react";
import DropdownButton from 'react-bootstrap/DropdownButton';
import Dropdown from 'react-bootstrap/Dropdown'

export default class Testcomp extends Component {
    constructor(props) {
        super(props);
        this.state = {
          error: null,
          isLoaded: false,
          items: []
        };
      }

    componentDidMount() {

        fetch('http://localhost:8000/api/categories', {
            method: 'GET',
            headers: {'accept': 'application/json',
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

        // Note: it's important to handle errors here
        // instead of a catch() block so that we don't swallow
        // exceptions from actual bugs in components.
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
        if (error) {
          return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
          return <div>Loading...</div>;
        } else {
          return (
            <DropdownButton className="transparent" variant="light" id="dropdown-basic-button" title="Shop by category">
                {items.map(item => (
                    <Dropdown.Item key={item.id} href="#">{item.name}</Dropdown.Item>
                ))}
            </DropdownButton>
          );
        }
      }
}
