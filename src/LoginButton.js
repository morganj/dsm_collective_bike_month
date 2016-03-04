import React from 'react';
import ReactDOM from 'react-dom';
import lorem from 'lorem-ipsum';
import {Button, Dialog, Input} from 'react-toolbox';


export default class LoginButton extends React.Component {

    state = {active: false}

    handleToggle() {
        this.setState({active: !this.state.active});
    }

    handleChange(name, value) {
        if (value === 'secret') {
            this.setState({success: <h1>It worked!</h1>});
        }
    }

    render() {
        let view = (
            <div>
                <h1>Bacoon Ride</h1>
                <p>{lorem({count: 3})}</p>
                <img className='' src='./img/event-logo.jpg' width='200' height='200'/>
                <Button label='Unlock' onClick={this.handleToggle.bind(this)} raised primary/>
                <Dialog actions={this.props.actions} active={this.state.active} title='Enter the code'
                        onOverlayClick={this.handleToggle.bind(this)}>
                    <Input type='text' label='Event Code' name='code' value={this.state.code}
                           onChange={this.handleChange.bind(this, 'code')}/>
                </Dialog>
                {this.state.success}
            </div>
        );

        return view;
    }
}
