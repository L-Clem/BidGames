import React, { Component, useEffect, useState } from "react";

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

        fetch('http://localhost:8000/api/departments', {
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

    // render() {
    //     const { error, isLoaded, items } = this.state;
    //     if (error) {
    //       return <div>Error: {error.message}</div>;
    //     } else if (!isLoaded) {
    //       return <div>Loading...</div>;
    //     } else {
    //       return (
    //           <ul>
    //           {items.map(item => (
    //             <li key={item.id}>
    //               {item.name}
    //             </li>
    //           ))}
    //         </ul>
    //       );
    //     }
    //   }
}
