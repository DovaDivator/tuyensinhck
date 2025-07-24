import { JSX, useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';

import IndexBackground from '../../views/ui/layout/IndexBackground';

import "./ManagerUserPage.scss";
import { useAppContext } from '../../context/AppContext';
import { useAuth } from '../../context/AuthContext';

const ManagerExamResultPage = (): JSX.Element => {
  return (
      <div>
      <Helmet>
        <title>Chấm điểm - Web tuyển sinh</title>
      </Helmet>
      <IndexBackground>
        <ManagerExamResultBody/>         
      </IndexBackground>
    </div>
    );
};

export default ManagerExamResultPage;

const ManagerExamResultBody = (): JSX.Element => {
    const {user, token} = useAuth();

    // if(!(user.isAdmin() || user.isTeacher())) return <></>;

  return (
        <div className='manager-exam-result-body'>
            <section className='manager-exam-result-header'>
                <h2 className='title'>Chấm điểm</h2>
                <p className='description'>Vui lòng chọn kỳ thi và môn thi để chấm!</p>
                <form></form>
            </section>
        </div>
    );
};
