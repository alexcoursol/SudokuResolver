import React from 'react'

class Submit extends React.Component {
    constructor(props) {
        super(props);
        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(e) {
        var self = this;

        axios.post('http://localhost:8000/api/test', {
            grid: JSON.stringify(this.props.grid)
        }).then(function (response) {
            console.log(response);

            if (! response.data.error) {
                self.props.callBack(response.data.grid);
            }
            
        }).catch(function (error) {
            console.log(error);
        });
    }

    render() {
        return (
            <input type="submit" onClick={this.handleClick} />
        );
    }
}

export default Submit