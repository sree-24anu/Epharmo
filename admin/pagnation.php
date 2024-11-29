<nav aria-label="Page navigation example">
                <ul class="pagination">

                    <!-- if totalpages is less than or equal to 4 -->

                    <?php

                    if (!isset($_POST['searchresult'])) {
                    $currentpage=$page + 1;
                    if ($totalpages <= 6) {
                        for ($i = 1; $i <= $totalpages; $i++) {
                            if ($i == $currentpage) {
                                echo ' <li class="page-item active" aria-current="page"><a class="page-link">' . $i . '</a></li>';
                            } else {
                            echo ' <li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                    }

                    // if totalpages is greater than 4
                    else if ($totalpages > 6) 
                    {

                        // current page less than 4
                    
                        if ($currentpage <= 4) 
                        {
                            for ($i = 1; $i <= 4; $i++) 
                            {
                                if ($i == $currentpage) 
                                {
                                    echo ' <li class="page-item active" aria-current="page"><a class="page-link">' . $i . '</a></li>';
                                } 
                                else 
                                {
                                    echo ' <li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $i . '">' . $i . '</a></li>';
                                }

                            }
                             if ($currentpage == 4) 
                             {
                                    echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $page + 2 . '">' . $page + 2 . '</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="">....</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $totalpages . '">' . $totalpages . '</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a class="page-link" href="">....</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $totalpages . '">' . $totalpages . '</a></li>';
                                }
                             }
                        
                    

                    // currentpage greater than 4 nd less than total number of pages -1
                    else if ($currentpage > 4 && $currentpage < $totalpages - 1) 
                    {
                        if ($currentpage == $totalpages - 2) {
                            echo '<li class="page-item"><a class="page-link" href="">1</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="">....</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $page . '">' . $page . '</a></li>';
                            echo '<li class="page-item active"><a class="page-link" href="">' . $currentpage . '</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $page + 2 . '">' . $page + 2 . '</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $totalpages . '">' . $totalpages . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="">1</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="">....</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $page . '">' . $page . '</a></li>';
                            echo '<li class="page-item active"><a class="page-link" href="">' . $currentpage . '</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $page + 2 . '">' . $page + 2 . '</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="">.....</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $totalpages . '">' . $totalpages . '</a></li>';

                        }
                    }


                    // current page greater than 4
                    else if ($currentpage > 4) {
                        if ($currentpage == $totalpages - 1) {
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=1">1</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="">....</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $totalpages - 2 . '">' . $totalpages - 2 . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=1">1</a></li>';
                            echo '<li class="page-item"><a class="page-link" href="">....</a></li>';
                        }
                        for ($i = $totalpages - 1; $i <= $totalpages; $i++) {

                            if ($i == $currentpage) {
                                echo ' <li class="page-item active" aria-current="page"><a class="page-link">' . $i . '</a></li>';
                            } else {
                                echo ' <li class="page-item"><a class="page-link" href="'. $pg_name .'?pages=' . $i . '">' . $i . '</a></li>';
                            }


                        }

                    }
                }
            }
                    ?>

                </ul>
            </nav>