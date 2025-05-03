import React from "react";

import './Card.scss';

const Card = ({children, className = '', hover = false}) => {
    return(
        <div className={`card ${className} ${hover ? 'hover' : ''}`}>
            {children}
        </div>
    );
}

export default Card;