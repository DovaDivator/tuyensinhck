import { useState, useEffect, useRef } from 'react';

/**
 * Custom hook để kiểm tra có scrollbar hay không
 * @returns [hasScrollbar, listRef] - Trả về trạng thái có scrollbar dưới dạng useState (boolean)
 */
const useScrollbar = () => {
    const [hasScrollbar, setHasScrollbar] = useState(false);
    const listRef = useRef(null);

    const checkScrollbar = () => {
        if (listRef.current) {
            const hasScroll = listRef.current.scrollWidth > listRef.current.clientWidth;
            setHasScrollbar(hasScroll);
        }
    };

    useEffect(() => {
        checkScrollbar();
        window.addEventListener("resize", checkScrollbar);
        return () => window.removeEventListener("resize", checkScrollbar);
    }, []);

    return [hasScrollbar, listRef];
};

export default useScrollbar;
