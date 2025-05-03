import React, { useEffect } from 'react';
import './IndexBackground.scss';
import { toggleScrollAnimation } from '../../../function/triggers/toggleScrollAnimation';

const IndexBackground = ({ children, delay = 0 }) => {
  useEffect(() => {
    if (delay !== 0) {
      toggleScrollAnimation('.index-background__content', delay);
    }
  }, []);

  return (
    <div className="index-background">
      <div className="index-background__content">
        {children}
      </div>
    </div>
  );
};

export default IndexBackground;