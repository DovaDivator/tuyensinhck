import {JSX, useState, useEffect } from 'react';
import { jsxEleProps } from '../../../types/jsxElementClass';

import "./Countdown.scss";

const Countdown = ({className = ""} : jsxEleProps):JSX.Element => {
  const [timeLeft, setTimeLeft] = useState({
    days: 999,
    hours: 23,
    minutes: 59,
    seconds: 59,
  });
  const [currentTime, setCurrentTime] = useState<number | null>(null);

          const targetDate = new Date('2026-01-01T00:00:00+07:00').getTime();

  useEffect(() => {
    // Gọi API một lần để lấy thời gian Việt Nam
    fetch('https://timeapi.io/api/Time/current/zone?timeZone=Asia/Ho_Chi_Minh')
      .then(response => response.json())
      .then(data => {
        const vietnamTime = new Date(data.dateTime).getTime();
        setCurrentTime(vietnamTime);
      })
      .catch(error => {
        console.error('Lỗi khi lấy thời gian từ timeapi.io:', error);
        const fallbackTime = new Date().getTime();
        setCurrentTime(fallbackTime);
      });

    const interval = setInterval(() => {
      setCurrentTime(prev => {
        if (prev === null) return prev;

        if (prev >= targetDate) {
          clearInterval(interval);
          return prev;
        }

        return prev + 1000;
      });
    }, 1000);

    return () => clearInterval(interval); 
  }, []);

  useEffect(() => {
    if (currentTime === null) return;

    const updateCountdown = () => {
      const distance = targetDate - currentTime;

      if (distance <= 0) return;

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      setTimeLeft({ days, hours, minutes, seconds });
    };

    updateCountdown();
  }, [currentTime]);

  return (
    <div className={`countdown-container ${className}`}>
            <div className={`countdown-unit`}>
              <span className={`countdown-unit__time`}>{timeLeft.days}</span>
              <span className={`countdown-unit__name`}>Ngày</span>
            </div>
            <div className={`countdown-unit`}>
              <span className={`countdown-unit__time`}>{timeLeft.hours}</span>
              <span className={`countdown-unit__name`}>Giờ</span>
            </div>
            <div className={`countdown-unit`}>
              <span className={`countdown-unit__time`}>{timeLeft.minutes}</span>
              <span className={`countdown-unit__name`}>Phút</span>
            </div>
            <div className={`countdown-unit`}>
              <span className={`countdown-unit__time`}>{timeLeft.seconds}</span>
              <span className={`countdown-unit__name`}>Giây</span>
            </div>
    </div>
  );
};

export default Countdown;