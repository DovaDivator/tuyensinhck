import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { useInView } from "react-intersection-observer";

import introImg from "../../../assets/images/SquareSchool.jpg";
import IntroduceText from "../introduce/IntroduceText";
import "./IntroduceSection.scss";

const IntroduceSection = () => {
    const { ref, inView } = useInView({
        triggerOnce: true,
        threshold: 0.3,
    });
    const [animationClass, setAnimationClass] = useState("hide");

    useEffect(() => {
        if (inView) {
            setAnimationClass("start");
        }
    }, [inView]);

    return (
        <section className="introduce-section" ref={ref}>
            <div className="introduce-section__control">
                <figure className={`introduce-section__image ${animationClass}`}>
                    <img src={introImg} alt="ảnh giới thiệu"/>
                </figure>
                <div className={`introduce-section__limited ${animationClass}`}>
                    <div className={`introduce-section__limited__text`}>
                        <IntroduceText />
                    </div>
                    <Link to="/introduce" className={`introduce-section__limited__link`}>
                        <span>&gt;&gt;&nbsp;Xem thêm...</span>
                    </Link>
                </div>
            </div>
        </section>
    );
};

export default IntroduceSection;