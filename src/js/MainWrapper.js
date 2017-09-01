import React from 'react'
import Grid from './Grid'
import Submit from './Submit'

class MainWrapper extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            grid: [],
        };

        for (var i = 0; i < 9; i++) {
            this.state.grid.push(new Array(9).fill(0));
        }
    }
    
    resolve(resp) {
        this.setState({
            grid: resp
        });
    }

    render() {
        return (
            <div>
                <Grid grid={this.state.grid} />
                <Submit callBack={this.resolve.bind(this)} grid={this.state.grid}/>
            </div>
        );
    }
}

export default MainWrapper