export default [
    {
        styles: {
            left: '-10px',
            top: '-10px'
        },
        availablePath: [
            1, 4, 3
        ]
    }, // 0
    {
        styles: {
            left: '50%',
            top: '-10px',
            marginLeft: '-15px'
        },
        availablePath: [
            2, 4, 0
        ]
    }, // 1
    {
        styles: {
            right: '-10px',
            top: '-10px'
        },
        availablePath: [
            1, 4, 5
        ]
    }, // 2
    {
        styles: {
            left: '-10px',
            top: '50%',
            marginTop: '-15px'
        },
        availablePath: [
            0, 4, 6
        ]
    }, // 3
    {
        styles: {
            left: '50%',
            top: '50%',
            marginTop: '-15px',
            marginLeft: '-15px'
        },
        availablePath: [
            0, 1, 2, 3, 5, 6, 7, 8
        ]
    }, // 4
    {
        styles: {
            right: '-10px',
            top: '50%',
            marginTop: '-15px'
        },
        availablePath: [
            2, 4, 8
        ]
    }, // 5
    {
        styles: {
            left: '-10px',
            bottom: '-10px',
        },
        availablePath: [
            3, 4, 7
        ]
    }, // 6
    {
        styles: {
            bottom: '-10px',
            left: '50%',
            marginLeft: '-15px'
        },
        availablePath: [
            6, 4, 8
        ]
    }, // 7
    {
        styles: {
            right: '-10px',
            bottom: '-10px',
        },
        availablePath: [
            7, 4, 5
        ]
    } // 8
]
