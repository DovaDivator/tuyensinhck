import { useState, useEffect, JSX } from "react";
import { Link } from "react-router-dom";
import { useInView } from "react-intersection-observer";

import { jsxEleProps } from "../../../types/jsxElementClass";
import "./IntroduceHe.scss";

interface IntroduceHeProps extends jsxEleProps {
    type?: string;
}

const IntroduceHe = ({className = "", type = ""}: IntroduceHeProps): JSX.Element => {
    const [__html, setHtml] = useState<string>("Đang tải...");
    const [name, setName] = useState<string>("");

    const { ref, inView } = useInView({
        triggerOnce: true,
        threshold: 0.1,
    });

    const ANIMATION_CLASS_PHASE = ["hide", "start"];
    const [animationClass, setAnimationClass] = useState(ANIMATION_CLASS_PHASE[0]);

    useEffect(() => {
        if (inView) {
            setAnimationClass(ANIMATION_CLASS_PHASE[1]);
        }
    }, [inView]);

    useEffect(() => {
        /**
        * Điều phối trang và gắn giá trị hiển thị
        */
        const getPageInfo = async () => {
        switch (type) {
            case 'dai-hoc':
                setName("đại học");
                fetchTxtFile('/data/htmlHeDaiHoc.txt')
                break;
            case 'cao-dang':
                setName("cao đẳng");
                setHtml("<p>Thông tin hệ cao đẳng...</p>");
                break;
            case 'lien-thong':
                setName("liên thông");
                setHtml("<p>Thông tin hệ liên thông...</p>");
                break;
            default:
                setName("Không xác định");
                console.error(`Lỗi type không hợp lệ ${type}`);
                break;
        }
        
        };

        const fetchTxtFile = async (link: string) => {
            let loadedHtml = "";
            const res = await fetch(link);
            loadedHtml = await res.text();
            setHtml(loadedHtml);
        }

        getPageInfo();
    }, [type]);

    return (
        <section className={`introduce-he-section ${className}`} ref={ref}>
            <h2>Khám phá hệ {name}</h2>
            <div className="introduce-he-section__container"
                dangerouslySetInnerHTML={{__html}}
            >    
            </div>
        </section>
    );
};

export default IntroduceHe;