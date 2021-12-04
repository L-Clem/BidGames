import React, { Component } from "react";
import ReactDOM from "react-dom";

console.log('hello1')

const me = <h2>hello there <span>memememe</span></h2>
console.log('hello2')


ReactDOM.render(me, document.getElementById('testid'));

console.log('hello3')


class Testcomp extends Component {
    render() {
        return <h2>hello there <span>memememe</span></h2>;
    }
}

console.log(<Testcomp />)

export default Testcomp;



