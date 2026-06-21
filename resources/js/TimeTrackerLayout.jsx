import React, { useState, useEffect } from 'react';

const formatTime = (totalSeconds) => {
  const hrs = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
  const mins = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
  const secs = String(totalSeconds % 60).padStart(2, '0');
  return `${hrs}:${mins}:${secs}`;
};

const NavTab = ({ label, active }) => (
  <button
    className={`px-4 py-2 text-sm font-medium transition-colors ${
      active
        ? 'text-blue-600 border-b-2 border-blue-600'
        : 'text-gray-600 hover:text-gray-900'
    }`}
  >
    {label}
  </button>
);

const Divider = () => <div className="w-px h-6 bg-gray-300" />;

const TimeTrackerLayout = () => {
  const [task, setTask] = useState('');
  const [isActive, setIsActive] = useState(false);
  const [seconds, setSeconds] = useState(0);

  useEffect(() => {
    let interval = null;
    if (isActive) {
      interval = setInterval(() => {
        setSeconds((prev) => prev + 1);
      }, 1000);
    }
    return () => {
      if (interval) clearInterval(interval);
    };
  }, [isActive]);

  const toggleTimer = () => setIsActive((prev) => !prev);

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Top Navigation Bar */}
      <header className="bg-white border-b border-gray-200">
        <div className="flex items-center justify-between px-6 h-14">
          {/* Left: Logo */}
          <div className="flex items-center gap-3">
            <button className="text-gray-600 hover:text-gray-900">
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
            <span className="text-xl font-bold tracking-tight">
              <span className="text-blue-600">SINNO</span>{' '}
              <span className="text-gray-900">Time Tracker</span>
            </span>
          </div>

          {/* Right: Nav Tabs */}
          <nav className="flex items-center h-full">
            <NavTab label="My Time" />
            <NavTab label="Overview" active />
            <NavTab label="Management" />
            <NavTab label="Reporting" />
            <NavTab label="Configuration" />
          </nav>
        </div>
      </header>

      {/* Live Timer Bar */}
      <div className="bg-white border-b border-gray-200 shadow-sm">
        <div className="flex items-center gap-3 px-6 h-16">
          {/* Task Input */}
          <input
            type="text"
            value={task}
            onChange={(e) => setTask(e.target.value)}
            placeholder="What are you working on?"
            className="flex-1 h-10 px-3 text-sm text-gray-700 placeholder-gray-400 bg-gray-50 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
          />

          <Divider />

          {/* + Project */}
          <button className="flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 whitespace-nowrap">
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
            </svg>
            Project
          </button>

          <Divider />

          {/* Tag */}
          <button className="text-gray-500 hover:text-gray-700">
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
          </button>

          <Divider />

          {/* Billable */}
          <button className="text-gray-500 hover:text-gray-700 font-bold text-sm w-6 h-6 flex items-center justify-center border border-gray-300 rounded">
            $
          </button>

          <Divider />

          {/* Timer */}
          <span className="text-lg font-mono font-semibold text-gray-800 min-w-[80px] text-center tabular-nums">
            {formatTime(seconds)}
          </span>

          {/* Start / Stop Button */}
          <button
            onClick={toggleTimer}
            className={`px-4 py-1.5 text-sm font-semibold text-white rounded transition-colors ${
              isActive
                ? 'bg-red-600 hover:bg-red-700'
                : 'bg-blue-600 hover:bg-blue-700'
            }`}
          >
            {isActive ? 'STOP' : 'START'}
          </button>

          {/* 3-dots menu */}
          <button className="text-gray-500 hover:text-gray-700">
            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
          </button>
        </div>
      </div>

      {/* Main Content */}
      <main className="max-w-5xl mx-auto px-6 py-8">
        <h1 className="text-2xl font-bold text-gray-900 mb-6">Overview</h1>
        <div className="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
          <p className="text-gray-500 text-sm">
            Organization-wide attendance overview and summaries will appear here.
          </p>
        </div>
      </main>
    </div>
  );
};

export default TimeTrackerLayout;
