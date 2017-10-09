public class Main { static TimerThread timeThr = new TimerThread();
                        static RunThread runThr = new RunThread();
                        static class TimerThread extends Thread {
                            public void run() {
                                try {
                                    sleep(3000);
                                    runThr.stop();
                                    System.out.println("OverTime");
                                    System.exit(0);
                                } catch (InterruptedException e) {}
                            }
                        }
                        static class RunThread extends Thread {
                            public void run() {
                                long start = System.currentTimeMillis();
                                Runtime runtime = Runtime.getRuntime();
                                runtime.gc();
                                long mem = runtime.totalMemory() - runtime.freeMemory();
                               
		System.out.println("H");
		System.out.println("e");
		System.out.println("l");
		System.out.println("l");
		System.out.println("o");
		System.out.println(" ");
		System.out.println("W");
//		System.out.println("o");
//		System.out.println("r");
//		System.out.println("l");
//		System.out.println("d");
	 long memNow = runtime.totalMemory() - runtime.freeMemory() - mem;
                                System.out.println("UsedMem:" + memNow/1024.0);
                                long time = System.currentTimeMillis() - start;
                                timeThr.stop();
                                System.out.println("RunTime:" + time / 1000.0);
                            }
                        }

	public static void main(String[] args) {timeThr.start(); runThr.start();}

}
