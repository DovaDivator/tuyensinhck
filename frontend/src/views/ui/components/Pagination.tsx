import React, {JSX, useContext} from 'react';
import { AppContext } from "../../../context/AppContext";


import Button from '../input/Button';
import { jsxEleProps } from '../../../types/jsxElementInterfaces';
import "./Pagination.scss";

interface PaginationProps {
    currentNum: number;
    listLength: number;
}

type PaginationPageProps = PaginationProps & jsxEleProps;

const Pagination = ({
    currentNum = 1,
    listLength = 1,
    className = ""
}: PaginationPageProps): JSX.Element => {
    const {screenSize} = useContext(AppContext);
    const SMALL_SCREEN_WIDTH = 480;

    if (listLength < 1) {
        console.error(`Danh sách không hợp lệ: ${listLength}`);
        return (
            <div className={`pagination ${className}`}>
                <span className="error-message">Danh sách hiển thị lỗi</span>
            </div>
        );
    }

    if (currentNum < 1 || currentNum > listLength) {
        console.error(`Vị trí phần tử sai: ${currentNum} (Tổng số lượng: ${listLength})`);
        return (
            <div className={`pagination ${className}`}>
                <span className="error-message">Danh sách hiển thị lỗi</span>
            </div>
        );
    }

    let leftCurNum:number = screenSize.width < SMALL_SCREEN_WIDTH ? currentNum : currentNum < 3 ? 1 : currentNum - 2;
    let rightCurNum:number = screenSize.width < SMALL_SCREEN_WIDTH ? currentNum : (listLength - currentNum) > 2 ? currentNum + 2 : listLength;

    return(
        <div className={`pagination ${className}`}>
            <Button text="<" disabled={currentNum === 1}/>
            {leftCurNum > 1 && (
                <span>...</span>
            )}
            {(() => {
                const buttons = [];
                for (let page = leftCurNum; page <= rightCurNum; page++) {
                    buttons.push(
                        <Button
                            key={page}
                            className={currentNum === page ? 'current-num' : ''}
                            text={page.toString()}
                            disabled={currentNum === page}
                        />
                    );
                }
                return buttons;
            })()}

        {rightCurNum < listLength && <span>...</span>}
        <Button text=">" disabled={currentNum === listLength}/>
        </div>
    );
};

/**
 * Định nghĩa đầy đủ trong tệp `Pagination.tsx`.
 * @module Pagination
 */
export default React.memo(Pagination);