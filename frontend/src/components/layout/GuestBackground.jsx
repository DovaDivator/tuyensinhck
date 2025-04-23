import React, { useEffect } from 'react';
import Blur from './Blur';
import './GuestBackground.scss';
import { toggleScrollAnimation } from '../../function/triggers/toggleScrollAnimation';

const GuestBackground = ({ children, delay = 0}) => {
  useEffect(() => {
    if (delay !== 0) {
      toggleScrollAnimation('.guest-background__content', delay);
    }
  }, []);

  return (
    <div className="guest-background">
      <Blur />
      <div className="guest-background__content">
        {children}
      </div>
    </div>
  );
};

export default GuestBackground;