import React, { Component, useEffect, useState } from "react";
import InputGroup from 'react-bootstrap/InputGroup';
import FormControl from 'react-bootstrap/Form';
import SplitButton from 'react-bootstrap/Button';
import Dropdown from 'react-bootstrap/Dropdown'
import DropdownButton from 'react-bootstrap/DropdownButton'


export default class Searchbox extends Component {
    constructor(props) {
        super(props);
        this.state = {
          error: null,
          isLoaded: false,
          items: []
        };
    }

    componentDidMount() {
        this.handleText('')
    }

    // isJson = (str) => {
    //     try {
    //         let json = JSON.parse(str)
    //         return true
    //     } catch (e) {
    //         return false
    //     }
    // }

    handleText = (text) => {

        let oReq = new XMLHttpRequest(),
            url = 'http://localhost:8000/api/sales?q=' + text;

        oReq.open("GET", url, true);
        oReq.onload = (e) => {

            let response = oReq.response;
            let json = JSON.parse(response);
                console.log(json.data)
                this.setState({
                    data: json.data
                })
            // if (this.isJson(response)) {
                
            // } else {
            //     console.log('Mauvais format de réception...')
            // }
        }
        oReq.send();
    }

    render() {
        return (
            <div id="SearchBar">
                <form id="search-form">
                    <input type="text" id="textbox" placeholder="Search listings..." onChange={text => this.handleText(text)}/>
                    <input type="image"  id="submitSearch" src={require('../images/search.png')}  alt="Submit Search" />
                    <DropdownButton
                        variant="light"
                        title="Categories"
                        id="input-group-dropdown-1"
                        className="transparent"
                    >
                        <Dropdown.Item href="#">Action</Dropdown.Item>
                        <Dropdown.Item href="#">Another action</Dropdown.Item>
                        <Dropdown.Item href="#">Something else here</Dropdown.Item>
                        <Dropdown.Divider />
                        <Dropdown.Item href="#">Separated link</Dropdown.Item>
                    </DropdownButton>
                </form>
            </div>
        )
    }
}