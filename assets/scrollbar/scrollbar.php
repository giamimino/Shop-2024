<style>
        body {
            height: 200vh; /* Force scrollbar to appear */
        }

        /* Change the width of the scrollbar */
        ::-webkit-scrollbar {
            width: 6px; /* For vertical scrollbars */
            height: 6px; /* For horizontal scrollbars */
        }

        /* Track (background of the scrollbar) */
        ::-webkit-scrollbar-track {
            background-color: #e6e6e6;
            border-radius: 10px;
        }
        
        /* Handle (the part you can drag) */
        ::-webkit-scrollbar-thumb {
            background-color: #8888889f;
            border-radius: 15px;
        }
        
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #5555559f;
        }
    </style>