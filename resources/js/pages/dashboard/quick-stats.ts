export {};

type Stat = {
    approved: number;
    rejected: number;
    other: number;
};
type QuickStats = {
    this_month?: Stat;
    last_month?: Stat;
    this_year?: Stat;
};
declare global {
    var QUICK_STATS: QuickStats;
}

const dashboardQuickStatsThisMonthApproved = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-this-month-approved'
);
const dashboardQuickStatsThisMonthRejected = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-this-month-rejected'
);
const dashboardQuickStatsThisMonthOther = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-this-month-other'
);

const dashboardQuickStatsLastMonthApproved = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-last-month-approved'
);
const dashboardQuickStatsLastMonthRejected = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-last-month-rejected'
);
const dashboardQuickStatsLastMonthOther = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-last-month-other'
);

const dashboardQuickStatsThisYearApproved = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-this-year-approved'
);
const dashboardQuickStatsThisYearReject = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-this-year-rejected'
);
const dashboardQuickStatsThisYearOther = document.querySelector<HTMLDivElement>(
    '.js-dashboard-quick-stats-this-year-other'
);

if(dashboardQuickStatsThisMonthApproved) {
    dashboardQuickStatsThisMonthApproved.style.width = `${QUICK_STATS.this_month?.approved}%`;
    dashboardQuickStatsThisMonthApproved.ariaValueNow = `${QUICK_STATS.this_month?.approved ?? 0}`;
}
if(dashboardQuickStatsThisMonthRejected) {
    dashboardQuickStatsThisMonthRejected.style.width = `${QUICK_STATS.this_month?.rejected}%`;
    dashboardQuickStatsThisMonthRejected.ariaValueNow = `${QUICK_STATS.this_month?.rejected ?? 0}`;
}
if(dashboardQuickStatsThisMonthOther) {
    dashboardQuickStatsThisMonthOther.style.width = `${QUICK_STATS.this_month?.other}%`;
    dashboardQuickStatsThisMonthOther.ariaValueNow = `${QUICK_STATS.this_month?.other ?? 0}`;
}

if(dashboardQuickStatsLastMonthApproved) {
    dashboardQuickStatsLastMonthApproved.style.width = `${QUICK_STATS.last_month?.approved}%`;
    dashboardQuickStatsLastMonthApproved.ariaValueNow = `${QUICK_STATS.last_month?.approved ?? 0}`;
}
if(dashboardQuickStatsLastMonthRejected) {
    dashboardQuickStatsLastMonthRejected.style.width = `${QUICK_STATS.last_month?.rejected}%`;
    dashboardQuickStatsLastMonthRejected.ariaValueNow = `${QUICK_STATS.last_month?.rejected ?? 0}`;
}
if(dashboardQuickStatsLastMonthOther) {
    dashboardQuickStatsLastMonthOther.style.width = `${QUICK_STATS.last_month?.other}%`;
    dashboardQuickStatsLastMonthOther.ariaValueNow = `${QUICK_STATS.last_month?.other ?? 0}`;
}

if(dashboardQuickStatsThisYearApproved) {
    dashboardQuickStatsThisYearApproved.style.width = `${QUICK_STATS.this_year?.approved}%`;
    dashboardQuickStatsThisYearApproved.ariaValueNow = `${QUICK_STATS.this_year?.approved ?? 0}`;
}
if(dashboardQuickStatsThisYearReject) {
    dashboardQuickStatsThisYearReject.style.width = `${QUICK_STATS.this_year?.rejected}%`;
    dashboardQuickStatsThisYearReject.ariaValueNow = `${QUICK_STATS.this_year?.rejected ?? 0}`;
}
if(dashboardQuickStatsThisYearOther) {
    dashboardQuickStatsThisYearOther.style.width = `${QUICK_STATS.this_year?.other}%`;
    dashboardQuickStatsThisYearOther.ariaValueNow = `${QUICK_STATS.this_year?.other ?? 0}`;
}



