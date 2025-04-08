<?php
require 'common.php';
require 'connection.php';
require 'function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoreDeft</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="card.css?<?php echo $_SESSION['csrf_token']; ?>">
    <style>
        :root {
            --primary: #00008b;
            --secondary: #ffffff;
            --accent: #6366f1;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(145deg, #0a1022 0%, #1a2540 100%);
            padding: clamp(5rem, 12vw, 8rem) 0;
            position: relative;
            overflow: hidden;
            color: #ffffff;
            isolation: isolate;
            font-family: 'Inter', sans-serif;
            /* Modern font */
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 85% 15%, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            z-index: -1;
        }



        /* 3D Container */
        .three-d-container {
            perspective: 1500px;
            height: 400px;
            width: 100%;
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* SVG Styles */
        .cloud-group,
        .node-group {
            transform-style: preserve-3d;
        }

        .cloud-shape {
            fill: url(#cloud-grad);
            filter: url(#glow);
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        .data-node {
            fill: #6366f1;
            filter: url(#glow);
            opacity: 0.8;
        }

        .connection-line {
            stroke: #a5b4fc;
            stroke-width: 1.5;
            opacity: 0.6;
            stroke-dasharray: 4;
        }

        /* Typography */
        .hero-title {
            font-size: clamp(2.4rem, 3.5vw, 3rem);
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 1.75rem;
            background: linear-gradient(90deg, #ffffff 30%, #dbeafe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            font-weight: 400;
            opacity: 0.9;
            max-width: 520px;
            color: #d1d5db;
        }

        /* Buttons */
        .btn-modern {
            padding: 1rem 2.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: none;
        }

        .btn-primary-modern {
            background: linear-gradient(45deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-outline-modern {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-outline-modern:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent);
        }

        /* Stats */
        .stat-pro {
            background: rgba(255, 255, 255, 0.08);
            padding: 0.65rem 1.5rem;
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.9rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-pro:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .btn-modern {
                width: 200px;
                padding: 1rem 1rem;
                border-radius: 0.75rem;
                font-weight: 600;
                margin: auto;
            }

            .stat-pro {
                padding: 0.65rem 1.5rem;
                border-radius: 2rem;
                border: 1px solid rgba(255, 255, 255, 0.15);
                font-size: 0.8rem;
                font-weight: 500;
            }

            .three-d-container {
                height: 400px;
            }

            .hero-section {
                text-align: center;
            }

            .hero-subtitle {
                margin-left: auto;
                margin-right: auto;
            }

            .stat-group {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php include('nav.php'); ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 animated-entry" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="hero-title">
                        Master Computer Skills <span style="color: #6366f1;">for a Bright Future</span>
                    </h1>
                    <p class="hero-subtitle">
                        Gain the skills you need to succeed in the digital world—learn easily, grow faster!
                    </p>

                    <div class="d-flex gap-3 mt-4 mb-4">
                        <button class="btn btn-primary-modern btn-modern">
                            Enroll Now
                        </button>
                        <button class="btn btn-outline-modern btn-modern">
                            Explore More
                        </button>
                    </div>

                    <div class="stat-group d-flex gap-3">
                        <div class="stat-pro">
                            <span class="fw-semibold">1000+</span> Happy Students
                        </div>
                        <div class="stat-pro">
                            <span class="fw-semibold">300+ 5⭐</span> Ratings
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 animated-entry" data-aos="fade-up" data-aos-delay="400">
                    <div class="three-d-container">
                        <svg id="cloud-svg" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="cloud-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#a5b4fc;stop-opacity:1" />
                                </linearGradient>
                                <filter id="glow">
                                    <feGaussianBlur stdDeviation="3" result="glow" />
                                    <feMerge>
                                        <feMergeNode in="glow" />
                                        <feMergeNode in="SourceGraphic" />
                                    </feMerge>
                                </filter>
                            </defs>

                            <!-- Cloud Group -->
                            <g class="cloud-group">
                                <path class="cloud-shape" d="M220,340 Q280,280 340,340 Q400,400 340,460 Q280,520 220,460 Q160,400 220,340 Z" />
                                <path class="cloud-shape" d="M240,300 Q290,250 340,300 Q380,340 340,380 Q290,420 240,380 Q200,340 240,300 Z" transform="translate(0, -60) scale(0.85)" />
                                <path class="cloud-shape" d="M200,360 Q260,310 320,360 Q370,410 320,470 Q260,530 200,470 Q150,410 200,360 Z" transform="translate(-30, 20) scale(0.9)" opacity="0.65" />
                            </g>

                            <!-- Data Nodes and Connections -->
                            <g class="node-group">
                                <circle class="data-node" cx="420" cy="180" r="14" />
                                <circle class="data-node" cx="460" cy="280" r="12" />
                                <circle class="data-node" cx="380" cy="480" r="10" />
                                <line class="connection-line" x1="280" y1="400" x2="420" y2="180" />
                                <line class="connection-line" x1="280" y1="400" x2="460" y2="280" />
                                <line class="connection-line" x1="280" y1="400" x2="380" y2="480" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Courses -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 animated-entry">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="display-5 fw-bold mb-0">Featured Courses</h2>
                    <a href="#" class="btn btn-link text-decoration-none">
                        View All <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="row g-4">
                <?php include('card.php'); ?>
            </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
    <?php include('toast.php'); ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/MotionPathPlugin.min.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800
        });

        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(MotionPathPlugin);

            const cloudGroup = document.querySelector('.cloud-group');
            const nodes = document.querySelectorAll('.data-node');
            const lines = document.querySelectorAll('.connection-line');

            // 3D Cloud Rotation
            gsap.to(cloudGroup, {
                rotationY: 360,
                rotationX: 15,
                duration: 20,
                repeat: -1,
                ease: 'none',
                transformOrigin: 'center center'
            });

            // Subtle Floating Effect
            gsap.to(cloudGroup, {
                y: -15,
                duration: 4,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            // Data Nodes Animation
            nodes.forEach((node, index) => {
                gsap.to(node, {
                    scale: 1.15,
                    duration: 1.8,
                    repeat: -1,
                    yoyo: true,
                    ease: 'power1.inOut',
                    delay: index * 0.4
                });

                gsap.to(node, {
                    motionPath: {
                        path: [{
                                x: node.getAttribute('cx'),
                                y: node.getAttribute('cy')
                            },
                            {
                                x: parseFloat(node.getAttribute('cx')) + 25,
                                y: parseFloat(node.getAttribute('cy')) - 15
                            },
                            {
                                x: parseFloat(node.getAttribute('cx')) - 15,
                                y: parseFloat(node.getAttribute('cy')) + 25
                            },
                            {
                                x: node.getAttribute('cx'),
                                y: node.getAttribute('cy')
                            }
                        ],
                        curviness: 1.2
                    },
                    duration: 5 + index * 0.5,
                    repeat: -1,
                    ease: 'power1.inOut'
                });
            });

            // Connection Lines Pulse
            gsap.to(lines, {
                opacity: 0.85,
                duration: 2.5,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
                stagger: 0.3
            });
        });
    </script>
</body>

</html>