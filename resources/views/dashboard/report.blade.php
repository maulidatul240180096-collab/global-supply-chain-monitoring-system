<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #1e40af;
            font-size: 22px;
        }

        h2 {
            color: #1e40af;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        h3 {
            color: #334155;
            margin-bottom: 5px;
        }

        .section {
            margin-top: 25px;
        }

        .box {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        strong {
            color: #111827;
        }

    </style>

</head>

<body>


<h1>
Global Supply Chain Risk Intelligence Platform
</h1>


<p>
This report presents an overview of global export monitoring activities
based on country information, logistics infrastructure, export destination
analysis, and supply chain risk indicators.
The platform is designed to assist businesses in evaluating international
trade opportunities and identifying potential risks before making export decisions.
</p>



<div class="section">

<h2>
1. Dashboard Overview
</h2>


<div class="box">

<h3>Total Countries Monitored</h3>

<p>
The platform currently monitors 
<strong>{{ $totalCountries }} countries</strong>
worldwide.

This data provides a global reference for analyzing potential export markets,
economic conditions, geographical information, and international trade opportunities.
</p>

</div>



<div class="box">

<h3>Total Ports Monitored</h3>

<p>
The system monitors 
<strong>{{ $totalPorts }} strategic ports</strong>
that support global logistics activities.

Port information helps users understand transportation access,
shipping routes, and the availability of international trade infrastructure.
</p>

</div>



<div class="box">

<h3>Export Destination Analysis</h3>

<p>
There are currently 
<strong>{{ $exportDestinations }} selected export destinations</strong>
stored in the system.

These destinations can be further analyzed based on risk conditions,
country profiles, logistics capability, and market opportunities.
</p>

</div>


</div>




<div class="section">

<h2>
2. Supply Chain Risk Analysis
</h2>


<div class="box">

<h3>Highest Risk Country</h3>

<p>
The current highest risk country identified by the system is:

<strong>{{ $highestRiskCountry }}</strong>

This indicator represents the country with the highest calculated risk
based on available comparison data.
Users should consider economic conditions, logistics challenges,
and external factors before selecting this country as an export destination.
</p>

</div>



<div class="box">

<h3>Lowest Risk Country</h3>

<p>
The current lowest risk country identified by the system is:

<strong>{{ $lowestRiskCountry }}</strong>

This indicates a relatively more stable condition compared with other
analyzed destinations based on the available risk indicators.
</p>

</div>



<div class="box">

<h3>Average Risk Score</h3>

<p>
The average risk score obtained from the analysis is:

<strong>{{ $averageRisk }}</strong>

This value represents the overall risk condition from analyzed destinations.
A lower risk score indicates a more favorable environment for international trade activities.
</p>

</div>


</div>





<div class="section">

<h2>
3. Platform Features Description
</h2>


<h3>Country Insights</h3>

<p>
This module provides detailed information about countries,
including geographical data, economic information, currency,
and country profiles.
The information helps users identify suitable export markets.
</p>



<h3>Weather Conditions</h3>

<p>
This module provides weather monitoring information that may affect
global supply chain activities.
Weather conditions can influence shipping schedules,
transportation routes, and logistics operations.
</p>



<h3>Country Comparison</h3>

<p>
This feature allows users to compare multiple countries based on
available indicators.
Users can evaluate differences between countries before deciding
which market has better export potential.
</p>



<h3>Port Network</h3>

<p>
This module provides information regarding international ports
that support global transportation.
Port availability is an important factor in evaluating logistics efficiency
and supply chain connectivity.
</p>



<h3>Export Destinations</h3>

<p>
This feature allows users to save and monitor potential export destinations.
Saved countries can be reviewed for further analysis and decision-making.
</p>



<h3>News Intelligence</h3>

<p>
This module provides updated international trade and supply chain news.
The information helps users monitor external events that may influence
global logistics and export activities.
</p>


</div>



<div class="section">

<h2>
4. Conclusion
</h2>

<p>
Based on the generated dashboard report, the TradeIntel platform provides
a centralized monitoring system for analyzing global export opportunities,
logistics infrastructure, and supply chain risks.

The platform supports better decision-making by combining country data,
risk indicators, logistics information, and global news intelligence into
one integrated system.
</p>


</div>


</body>
</html>