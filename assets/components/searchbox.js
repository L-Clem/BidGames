import React, { Component, useEffect, useState } from "react";

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
                <form>
                    <input type="text" placeholder="Search listings..." onChange={text => this.handleText(text)}/>
                </form>
            </div>
        )
    }

}