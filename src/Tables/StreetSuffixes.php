<?php

namespace Cdburgess\AddressingStandards\Tables;

class StreetSuffixes
{
    use Standardizes;

    /**
     * Street suffix abbreviations (Pub 28 Appendix C).
     * Key = any common form (uppercase), Value = official USPS standard abbreviation.
     * @link https://pe.usps.com/text/pub28/28apc_002.htm
     */
    public static function all(): array
    {
        return [
            // A
            'ALLEY' => 'ALY', 'ALLEE' => 'ALY', 'ALLY' => 'ALY', 'ALY' => 'ALY',
            'ANEX' => 'ANX', 'ANNEX' => 'ANX', 'ANNX' => 'ANX', 'ANX' => 'ANX',
            'ARCADE' => 'ARC', 'ARC' => 'ARC',
            'AVENUE' => 'AVE', 'AV' => 'AVE', 'AVE' => 'AVE', 'AVEN' => 'AVE',
            'AVENU' => 'AVE', 'AVN' => 'AVE', 'AVNUE' => 'AVE',

            // B
            'BAYOU' => 'BYU', 'BAYOO' => 'BYU', 'BYU' => 'BYU',
            'BEACH' => 'BCH', 'BCH' => 'BCH',
            'BEND' => 'BND', 'BND' => 'BND',
            'BLUFF' => 'BLF', 'BLF' => 'BLF', 'BLUF' => 'BLF',
            'BLUFFS' => 'BLFS', 'BLFS' => 'BLFS',
            'BOTTOM' => 'BTM', 'BOT' => 'BTM', 'BOTTM' => 'BTM', 'BTM' => 'BTM',
            'BOULEVARD' => 'BLVD', 'BLVD' => 'BLVD', 'BOUL' => 'BLVD', 'BOULV' => 'BLVD',
            'BRANCH' => 'BR', 'BR' => 'BR', 'BRNCH' => 'BR',
            'BRIDGE' => 'BRG', 'BRDGE' => 'BRG', 'BRG' => 'BRG',
            'BROOK' => 'BRK', 'BRK' => 'BRK',
            'BROOKS' => 'BRKS', 'BRKS' => 'BRKS',
            'BURG' => 'BG', 'BG' => 'BG',
            'BURGS' => 'BGS', 'BGS' => 'BGS',
            'BYPASS' => 'BYP', 'BYP' => 'BYP', 'BYPA' => 'BYP', 'BYPAS' => 'BYP', 'BYPS' => 'BYP',

            // C
            'CAMP' => 'CP', 'CP' => 'CP', 'CMP' => 'CP',
            'CANYON' => 'CYN', 'CANYN' => 'CYN', 'CNYN' => 'CYN', 'CYN' => 'CYN',
            'CAPE' => 'CPE', 'CPE' => 'CPE',
            'CAUSEWAY' => 'CSWY', 'CAUSWA' => 'CSWY', 'CSWY' => 'CSWY',
            'CENTER' => 'CTR', 'CEN' => 'CTR', 'CENT' => 'CTR', 'CENTR' => 'CTR',
            'CENTRE' => 'CTR', 'CNTER' => 'CTR', 'CNTR' => 'CTR', 'CTR' => 'CTR',
            'CENTERS' => 'CTRS', 'CTRS' => 'CTRS',
            'CIRCLE' => 'CIR', 'CIR' => 'CIR', 'CIRC' => 'CIR', 'CIRCL' => 'CIR',
            'CRCL' => 'CIR', 'CRCLE' => 'CIR',
            'CIRCLES' => 'CIRS', 'CIRS' => 'CIRS',
            'CLIFF' => 'CLF', 'CLF' => 'CLF',
            'CLIFFS' => 'CLFS', 'CLFS' => 'CLFS',
            'CLUB' => 'CLB', 'CLB' => 'CLB',
            'COMMON' => 'CMN', 'CMN' => 'CMN',
            'COMMONS' => 'CMNS', 'CMNS' => 'CMNS',
            'CORNER' => 'COR', 'COR' => 'COR',
            'CORNERS' => 'CORS', 'CORS' => 'CORS',
            'COURSE' => 'CRSE', 'CRSE' => 'CRSE',
            'COURT' => 'CT', 'CT' => 'CT',
            'COURTS' => 'CTS', 'CTS' => 'CTS',
            'COVE' => 'CV', 'CV' => 'CV',
            'COVES' => 'CVS', 'CVS' => 'CVS',
            'CREEK' => 'CRK', 'CRK' => 'CRK',
            'CRESCENT' => 'CRES', 'CRES' => 'CRES', 'CRSENT' => 'CRES', 'CRSNT' => 'CRES',
            'CREST' => 'CRST', 'CRST' => 'CRST',
            'CROSSING' => 'XING', 'CRSSNG' => 'XING', 'XING' => 'XING',
            'CROSSROAD' => 'XRD', 'XRD' => 'XRD',
            'CROSSROADS' => 'XRDS', 'XRDS' => 'XRDS',
            'CURVE' => 'CURV', 'CURV' => 'CURV',

            // D
            'DALE' => 'DL', 'DL' => 'DL',
            'DAM' => 'DM', 'DM' => 'DM',
            'DIVIDE' => 'DV', 'DIV' => 'DV', 'DVD' => 'DV', 'DV' => 'DV',
            'DRIVE' => 'DR', 'DR' => 'DR', 'DRIV' => 'DR', 'DRV' => 'DR',
            'DRIVES' => 'DRS', 'DRS' => 'DRS',

            // E
            'ESTATE' => 'EST', 'EST' => 'EST',
            'ESTATES' => 'ESTS', 'ESTS' => 'ESTS',
            'EXPRESSWAY' => 'EXPY', 'EXP' => 'EXPY', 'EXPR' => 'EXPY', 'EXPRESS' => 'EXPY',
            'EXPW' => 'EXPY', 'EXPY' => 'EXPY',
            'EXTENSION' => 'EXT', 'EXT' => 'EXT', 'EXTN' => 'EXT', 'EXTNSN' => 'EXT',
            'EXTENSIONS' => 'EXTS', 'EXTS' => 'EXTS',

            // F
            'FALL' => 'FALL',
            'FALLS' => 'FLS', 'FLS' => 'FLS',
            'FERRY' => 'FRY', 'FRRY' => 'FRY', 'FRY' => 'FRY',
            'FIELD' => 'FLD', 'FLD' => 'FLD',
            'FIELDS' => 'FLDS', 'FLDS' => 'FLDS',
            'FLAT' => 'FLT', 'FLT' => 'FLT',
            'FLATS' => 'FLTS', 'FLTS' => 'FLTS',
            'FORD' => 'FRD', 'FRD' => 'FRD',
            'FORDS' => 'FRDS', 'FRDS' => 'FRDS',
            'FOREST' => 'FRST', 'FORESTS' => 'FRST', 'FRST' => 'FRST',
            'FORGE' => 'FRG', 'FORG' => 'FRG', 'FRG' => 'FRG',
            'FORGES' => 'FRGS', 'FRGS' => 'FRGS',
            'FORK' => 'FRK', 'FRK' => 'FRK',
            'FORKS' => 'FRKS', 'FRKS' => 'FRKS',
            'FORT' => 'FT', 'FRT' => 'FT', 'FT' => 'FT',
            'FREEWAY' => 'FWY', 'FREEWY' => 'FWY', 'FRWAY' => 'FWY', 'FRWY' => 'FWY', 'FWY' => 'FWY',

            // G
            'GARDEN' => 'GDN', 'GARDN' => 'GDN', 'GRDEN' => 'GDN', 'GRDN' => 'GDN', 'GDN' => 'GDN',
            'GARDENS' => 'GDNS', 'GDNS' => 'GDNS', 'GRDNS' => 'GDNS',
            'GATEWAY' => 'GTWY', 'GATEWY' => 'GTWY', 'GATWAY' => 'GTWY', 'GTWAY' => 'GTWY', 'GTWY' => 'GTWY',
            'GLEN' => 'GLN', 'GLN' => 'GLN',
            'GLENS' => 'GLNS', 'GLNS' => 'GLNS',
            'GREEN' => 'GRN', 'GRN' => 'GRN',
            'GREENS' => 'GRNS', 'GRNS' => 'GRNS',
            'GROVE' => 'GRV', 'GROV' => 'GRV', 'GRV' => 'GRV',
            'GROVES' => 'GRVS', 'GRVS' => 'GRVS',

            // H
            'HARBOR' => 'HBR', 'HARB' => 'HBR', 'HARBR' => 'HBR', 'HBR' => 'HBR', 'HRBOR' => 'HBR',
            'HARBORS' => 'HBRS', 'HBRS' => 'HBRS',
            'HAVEN' => 'HVN', 'HVN' => 'HVN',
            'HEIGHTS' => 'HTS', 'HT' => 'HTS', 'HTS' => 'HTS',
            'HIGHWAY' => 'HWY', 'HIGHWY' => 'HWY', 'HIWAY' => 'HWY',
            'HIWY' => 'HWY', 'HWAY' => 'HWY', 'HWY' => 'HWY',
            'HILL' => 'HL', 'HL' => 'HL',
            'HILLS' => 'HLS', 'HLS' => 'HLS',
            'HOLLOW' => 'HOLW', 'HLLW' => 'HOLW', 'HOLLOWS' => 'HOLW', 'HOLW' => 'HOLW', 'HOLWS' => 'HOLW',

            // I
            'INLET' => 'INLT', 'INLT' => 'INLT',
            'ISLAND' => 'IS', 'IS' => 'IS', 'ISLND' => 'IS',
            'ISLANDS' => 'ISS', 'ISLNDS' => 'ISS', 'ISS' => 'ISS',
            'ISLE' => 'ISLE', 'ISLES' => 'ISLE',

            // J
            'JUNCTION' => 'JCT', 'JCT' => 'JCT', 'JCTION' => 'JCT', 'JCTN' => 'JCT', 'JUNCTN' => 'JCT', 'JUNCTON' => 'JCT',
            'JUNCTIONS' => 'JCTS', 'JCTNS' => 'JCTS', 'JCTS' => 'JCTS',

            // K
            'KEY' => 'KY', 'KY' => 'KY',
            'KEYS' => 'KYS', 'KYS' => 'KYS',
            'KNOLL' => 'KNL', 'KNL' => 'KNL', 'KNOL' => 'KNL',
            'KNOLLS' => 'KNLS', 'KNLS' => 'KNLS',

            // L
            'LAKE' => 'LK', 'LK' => 'LK',
            'LAKES' => 'LKS', 'LKS' => 'LKS',
            'LAND' => 'LAND',
            'LANDING' => 'LNDG', 'LNDG' => 'LNDG', 'LNDNG' => 'LNDG',
            'LANE' => 'LN', 'LN' => 'LN',
            'LIGHT' => 'LGT', 'LGT' => 'LGT',
            'LIGHTS' => 'LGTS', 'LGTS' => 'LGTS',
            'LOAF' => 'LF', 'LF' => 'LF',
            'LOCK' => 'LCK', 'LCK' => 'LCK',
            'LOCKS' => 'LCKS', 'LCKS' => 'LCKS',
            'LODGE' => 'LDG', 'LDG' => 'LDG', 'LODG' => 'LDG',
            'LOOP' => 'LOOP', 'LOOPS' => 'LOOP',

            // M
            'MALL' => 'MALL',
            'MANOR' => 'MNR', 'MNR' => 'MNR',
            'MANORS' => 'MNRS', 'MNRS' => 'MNRS',
            'MEADOW' => 'MDW', 'MDW' => 'MDW',
            'MEADOWS' => 'MDWS', 'MDWS' => 'MDWS', 'MEDOWS' => 'MDWS',
            'MEWS' => 'MEWS',
            'MILL' => 'ML', 'ML' => 'ML',
            'MILLS' => 'MLS', 'MLS' => 'MLS',
            'MISSION' => 'MSN', 'MISSN' => 'MSN', 'MSSN' => 'MSN', 'MSN' => 'MSN',
            'MOTORWAY' => 'MTWY', 'MTWY' => 'MTWY',
            'MOUNT' => 'MT', 'MNT' => 'MT', 'MT' => 'MT',
            'MOUNTAIN' => 'MTN', 'MNTAIN' => 'MTN', 'MNTN' => 'MTN', 'MOUNTIN' => 'MTN',
            'MTIN' => 'MTN', 'MTN' => 'MTN',
            'MOUNTAINS' => 'MTNS', 'MNTNS' => 'MTNS', 'MTNS' => 'MTNS',

            // N
            'NECK' => 'NCK', 'NCK' => 'NCK',

            // O
            'ORCHARD' => 'ORCH', 'ORCH' => 'ORCH', 'ORCHRD' => 'ORCH',
            'OVAL' => 'OVAL', 'OVL' => 'OVAL',
            'OVERPASS' => 'OPAS', 'OPAS' => 'OPAS',

            // P
            'PARK' => 'PARK', 'PRK' => 'PARK',
            'PARKS' => 'PARK',
            'PARKWAY' => 'PKWY', 'PARKWY' => 'PKWY', 'PKWAY' => 'PKWY',
            'PKWY' => 'PKWY', 'PKY' => 'PKWY',
            'PARKWAYS' => 'PKWY',
            'PASS' => 'PASS',
            'PASSAGE' => 'PSGE', 'PSGE' => 'PSGE',
            'PATH' => 'PATH', 'PATHS' => 'PATH',
            'PIKE' => 'PIKE', 'PIKES' => 'PIKE',
            'PINE' => 'PNE', 'PNE' => 'PNE',
            'PINES' => 'PNES', 'PNES' => 'PNES',
            'PLACE' => 'PL', 'PL' => 'PL',
            'PLAIN' => 'PLN', 'PLN' => 'PLN',
            'PLAINS' => 'PLNS', 'PLNS' => 'PLNS',
            'PLAZA' => 'PLZ', 'PLZ' => 'PLZ', 'PLZA' => 'PLZ',
            'POINT' => 'PT', 'PT' => 'PT',
            'POINTS' => 'PTS', 'PTS' => 'PTS',
            'PORT' => 'PRT', 'PRT' => 'PRT',
            'PORTS' => 'PRTS', 'PRTS' => 'PRTS',
            'PRAIRIE' => 'PR', 'PR' => 'PR', 'PRARIE' => 'PR', 'PRR' => 'PR',

            // R
            'RADIAL' => 'RADL', 'RAD' => 'RADL', 'RADIEL' => 'RADL', 'RADL' => 'RADL',
            'RAMP' => 'RAMP',
            'RANCH' => 'RNCH', 'RANCHES' => 'RNCH', 'RNCH' => 'RNCH', 'RNCHS' => 'RNCH',
            'RAPID' => 'RPD', 'RPD' => 'RPD',
            'RAPIDS' => 'RPDS', 'RPDS' => 'RPDS',
            'REST' => 'RST', 'RST' => 'RST',
            'RIDGE' => 'RDG', 'RDG' => 'RDG', 'RDGE' => 'RDG',
            'RIDGES' => 'RDGS', 'RDGS' => 'RDGS',
            'RIVER' => 'RIV', 'RIV' => 'RIV', 'RVR' => 'RIV', 'RIVR' => 'RIV',
            'ROAD' => 'RD', 'RD' => 'RD',
            'ROADS' => 'RDS', 'RDS' => 'RDS',
            'ROUTE' => 'RTE', 'RTE' => 'RTE',
            'ROW' => 'ROW',
            'RUE' => 'RUE',
            'RUN' => 'RUN',

            // S
            'SHOAL' => 'SHL', 'SHL' => 'SHL',
            'SHOALS' => 'SHLS', 'SHLS' => 'SHLS',
            'SHORE' => 'SHR', 'SHOAR' => 'SHR', 'SHR' => 'SHR',
            'SHORES' => 'SHRS', 'SHOARS' => 'SHRS', 'SHRS' => 'SHRS',
            'SKYWAY' => 'SKWY', 'SKWY' => 'SKWY',
            'SPRING' => 'SPG', 'SPG' => 'SPG', 'SPNG' => 'SPG', 'SPRNG' => 'SPG',
            'SPRINGS' => 'SPGS', 'SPGS' => 'SPGS', 'SPRNGS' => 'SPGS',
            'SPUR' => 'SPUR', 'SPURS' => 'SPUR',
            'SQUARE' => 'SQ', 'SQ' => 'SQ', 'SQR' => 'SQ', 'SQRE' => 'SQ', 'SQU' => 'SQ',
            'SQUARES' => 'SQS', 'SQRS' => 'SQS', 'SQS' => 'SQS',
            'STATION' => 'STA', 'STA' => 'STA', 'STATN' => 'STA', 'STN' => 'STA',
            'STRAVENUE' => 'STRA', 'STRA' => 'STRA', 'STRAV' => 'STRA', 'STRAVEN' => 'STRA',
            'STRAVN' => 'STRA', 'STRVN' => 'STRA', 'STRVNUE' => 'STRA',
            'STREAM' => 'STRM', 'STREME' => 'STRM', 'STRM' => 'STRM',
            'STREET' => 'ST', 'ST' => 'ST', 'STRT' => 'ST', 'STR' => 'ST',
            'STREETS' => 'STS', 'STS' => 'STS',
            'SUMMIT' => 'SMT', 'SMT' => 'SMT', 'SUMIT' => 'SMT', 'SUMITT' => 'SMT',

            // T
            'TERRACE' => 'TER', 'TER' => 'TER', 'TERR' => 'TER',
            'THROUGHWAY' => 'TRWY', 'TRWY' => 'TRWY',
            'TRACE' => 'TRCE', 'TRACES' => 'TRCE', 'TRCE' => 'TRCE',
            'TRACK' => 'TRAK', 'TRACKS' => 'TRAK', 'TRAK' => 'TRAK', 'TRK' => 'TRAK', 'TRKS' => 'TRAK',
            'TRAFFICWAY' => 'TRFY', 'TRFY' => 'TRFY',
            'TRAIL' => 'TRL', 'TRAILS' => 'TRL', 'TRL' => 'TRL', 'TRLS' => 'TRL',
            'TRAILER' => 'TRLR', 'TRLR' => 'TRLR', 'TRLRS' => 'TRLR',
            'TUNNEL' => 'TUNL', 'TUNEL' => 'TUNL', 'TUNL' => 'TUNL', 'TUNLS' => 'TUNL',
            'TUNNELS' => 'TUNL', 'TUNNL' => 'TUNL',
            'TURNPIKE' => 'TPKE', 'TRNPK' => 'TPKE', 'TPKE' => 'TPKE', 'TURNPK' => 'TPKE',

            // U
            'UNDERPASS' => 'UPAS', 'UPAS' => 'UPAS',
            'UNION' => 'UN', 'UN' => 'UN',
            'UNIONS' => 'UNS', 'UNS' => 'UNS',

            // V
            'VALLEY' => 'VLY', 'VALLY' => 'VLY', 'VLLY' => 'VLY', 'VLY' => 'VLY',
            'VALLEYS' => 'VLYS', 'VLYS' => 'VLYS',
            'VIADUCT' => 'VIA', 'VDCT' => 'VIA', 'VIA' => 'VIA', 'VIADCT' => 'VIA',
            'VIEW' => 'VW', 'VW' => 'VW',
            'VIEWS' => 'VWS', 'VWS' => 'VWS',
            'VILLAGE' => 'VLG', 'VILL' => 'VLG', 'VILLAG' => 'VLG', 'VILLG' => 'VLG',
            'VILLIAGE' => 'VLG', 'VLG' => 'VLG',
            'VILLAGES' => 'VLGS', 'VLGS' => 'VLGS',
            'VILLE' => 'VL', 'VL' => 'VL',
            'VISTA' => 'VIS', 'VIS' => 'VIS', 'VIST' => 'VIS', 'VST' => 'VIS', 'VSTA' => 'VIS',

            // W
            'WALK' => 'WALK', 'WALKS' => 'WALK',
            'WALL' => 'WALL',
            'WAY' => 'WAY', 'WY' => 'WAY',
            'WAYS' => 'WAYS',
            'WELL' => 'WL', 'WL' => 'WL',
            'WELLS' => 'WLS', 'WLS' => 'WLS',
        ];
    }
}