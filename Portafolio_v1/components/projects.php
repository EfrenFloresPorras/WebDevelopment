<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #292929;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .project-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .project-card:hover .card-img-overlay {
            opacity: 1;
        }
        .card-img-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
            background-color: rgba(0, 0, 0, 0.7);
        }
        .expanded-project {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .expanded-content {
            display: flex;
            width: 90%;
            height: 90%;
            background-color: #292929;
            border-radius: 10px;
            overflow: hidden;
            color: #ffffff;
        }
        .expanded-image {
            width: 50%;
            object-fit: cover;
        }
        .expanded-details {
            width: 50%;
            padding: 20px;
            overflow-y: auto;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }
        .project-filter {
            margin-bottom: 20px;
        }
        .project-filter .nav-link {
            color: #ffffff;
            cursor: pointer;
            border-radius: 20px;
            transition: all 0.3s ease;
            margin: 0 5px;
        }
        .project-filter .nav-link.active {
            background-color: #4a4a4a;
            color: #ffffff;
            font-weight: bold;
        }
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .skill-pill {
            background-color: #4a4a4a;
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">My Portfolio Projects</h1>
        
        <nav class="project-filter nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active" data-type="all">All Projects</a>
            <a class="flex-sm-fill text-sm-center nav-link" data-type="robotics">Robotics</a>
            <a class="flex-sm-fill text-sm-center nav-link" data-type="cybersecurity">Cybersecurity</a>
            <a class="flex-sm-fill text-sm-center nav-link" data-type="entrepreneurs">Entrepreneurs</a>
        </nav>

        <div id="projectContainer" class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Project cards will be dynamically inserted here -->
        </div>
    </div>

    <div id="expandedProject" class="expanded-project d-none">
        <div class="expanded-content">
            <img id="expandedImage" class="expanded-image" src="" alt="Project Image">
            <div id="expandedDetails" class="expanded-details">
                <!-- Expanded project details will be inserted here -->
            </div>
        </div>
        <span class="close-btn">&times;</span>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample project data
        const projects = [
            {
                id: 1,
                title: "Autonomous Robot",
                image: "./assets/images/FRC.jpg",
                description: "An autonomous robot capable of navigating complex environments.",
                type: "robotics",
                skills: ["Arduino", "C++", "Sensor Integration", "Machine Learning"]
            },
            {
                id: 2,
                title: "Intrusion Detection System",
                image: "./assets/images/pentesting.png",
                description: "A robust cybersecurity solution for detecting and preventing network intrusions.",
                type: "cybersecurity",
                skills: ["Python", "Network Protocols", "Machine Learning", "Data Analysis"]
            },
            {
                id: 3,
                title: "Tech Startup Incubator",
                image: "./assets/images/Stella_Ignis.jpg",
                description: "A program designed to support and nurture early-stage technology startups.",
                type: "entrepreneurs",
                skills: ["Business Development", "Mentoring", "Financial Planning", "Networking"]
            },
            // Add more projects as needed
        ];

        function createProjectCard(project) {
            return `
                <div class="col project-card" data-type="${project.type}" data-id="${project.id}">
                    <div class="card h-100 bg-dark">
                        <img src="${project.image}" class="card-img-top" alt="${project.title}">
                        <div class="card-img-overlay text-white d-flex flex-column justify-content-end">
                            <h5 class="card-title">${project.title}</h5>
                            <p class="card-text">${project.description}</p>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderProjects(filteredProjects = projects) {
            const container = document.getElementById('projectContainer');
            container.innerHTML = filteredProjects.map(createProjectCard).join('');
            
            // Add click event listeners to the new cards
            document.querySelectorAll('.project-card').forEach(card => {
                card.addEventListener('click', () => expandProject(filteredProjects.find(p => p.id === parseInt(card.dataset.id))));
            });
        }

        function expandProject(project) {
            const expandedProject = document.getElementById('expandedProject');
            const expandedImage = document.getElementById('expandedImage');
            const expandedDetails = document.getElementById('expandedDetails');

            expandedImage.src = project.image;
            expandedDetails.innerHTML = `
                <h2>${project.title}</h2>
                <p>${project.description}</p>
                <h4>Skills Used:</h4>
                <div class="skills-container">
                    ${project.skills.map(skill => `<span class="skill-pill">${skill}</span>`).join('')}
                </div>
            `;

            expandedProject.classList.remove('d-none');
        }

        // Filter projects based on selected type
        document.querySelectorAll('.project-filter .nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                // Remove active class from all links
                document.querySelectorAll('.project-filter .nav-link').forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                e.target.classList.add('active');

                const selectedType = e.target.dataset.type;
                const filteredProjects = selectedType === 'all' ? projects : projects.filter(p => p.type === selectedType);
                
                // Fade out current projects
                document.getElementById('projectContainer').style.opacity = 0;
                
                // Render new projects after a short delay
                setTimeout(() => {
                    renderProjects(filteredProjects);
                    // Fade in new projects
                    document.getElementById('projectContainer').style.opacity = 1;
                }, 300);
            });
        });

        // Close expanded project view
        document.querySelector('.close-btn').addEventListener('click', () => {
            document.getElementById('expandedProject').classList.add('d-none');
        });

        // Initial render
        renderProjects();
    </script>
</body>