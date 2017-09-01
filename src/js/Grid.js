import React from 'react'

class Grid extends React.Component {
    constructor(props) {
        super(props)

        this.handleClick = this.handleClick.bind(this);
        this.handleMouseDown = this.handleMouseDown.bind(this);
        this.handleMouseUp = this.handleMouseUp.bind(this);
        this.getClass = this.getClass.bind(this);
        
        this.state = {
            elemClicked: null,
            elemClickedClass: '',
            cellClass: 'cell button'
        };
    }

    handleMouseDown(e) {
        this.state.elemClicked = e.target;
        this.state.elemClickedClass = e.target.className;
        e.target.className = e.target.className + ' click';
    }

    handleMouseUp(e) {
        this.state.elemClicked.className = this.state.elemClickedClass;
    }

    handleClick(e) {
        var x = e.target.getAttribute('data-posX');
        var y = e.target.getAttribute('data-posY');

        if (this.props.grid[x][y] >= 9) {
            this.props.grid[x][y] = 0;
        } else {
            this.props.grid[x][y]++;
        }
        this.forceUpdate();
    }

    getClass(i, j) {

        if (j%3 == 0 && i%3 == 0 && j != 0 && i != 0) {
            return this.state.cellClass + ' border-top-left';
        }

        if (j%3 == 0 && j != 0) {
            return this.state.cellClass + ' border-left';
        }

        if (i%3 == 0 && i != 0) {
            return this.state.cellClass + ' border-top';
        }
        return this.state.cellClass;
    }

    render() {
        return(
            <div className="grid">
                {
                    this.props.grid.map((row, i) =>
                        <div className="row" key={i}>
                            {
                                row.map((cell, j) =>
                                    <div data-posX={i} data-posY={j} className={this.getClass(i, j)} key={j} onClick={this.handleClick} 
                                     onMouseDown={this.handleMouseDown} onMouseUp={this.handleMouseUp}>
                                        {this.props.grid[i][j] == 0 ? '' : this.props.grid[i][j]}
                                    </div>
                                )
                            }
                        </div>
                    )
                }
            </div>
        )
    }
}

export default Grid