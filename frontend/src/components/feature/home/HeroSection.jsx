import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useInView } from "react-intersection-observer";

import Button from "../../input/Button";
import "./HeroSection.scss";

const HeroSection = () => {
  const navigate = useNavigate();
  const [buttonAnimation, setButtonAnimation] = useState("start");

  const { ref, inView } = useInView({
    triggerOnce: true, 
    threshold: 0.3,
  });

  useEffect(() => {
    if (inView) {
      const startLoopAnimation = () => {
        setTimeout(() => {
          setButtonAnimation("loop");

          setTimeout(() => {
            setButtonAnimation("");
            setTimeout(startLoopAnimation, 5000);
          }, 1250);
        }, 5000);
      };

      startLoopAnimation();

      return () => {};
    }
  }, [inView]);

    return (
        <section className="hero-section" ref={ref}>
            <div className="blur"></div>
            <div>
                <h2 className="hero-section__title">Chào mừng đến với Trang tuyển sinh</h2>
                <p className="hero-section__description">Khám phá cơ hội học tập tại ngôi trường hàng đầu của chúng tôi</p>
                <Button
                    text="Đăng ký ngay!"
                    className={buttonAnimation}
                    onClick={() => navigate("/register")}
                />
            </div>
        </section>
    );
}

export default HeroSection;